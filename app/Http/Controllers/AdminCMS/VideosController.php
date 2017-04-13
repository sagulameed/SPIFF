<?php

namespace App\Http\Controllers\AdminCMS;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Video;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\AddVideoRequest;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId=null)
    {
        if(isset($categoryId)){
            $category = Category::find($categoryId);
            $videos = $category->videos;
        }
        else{
            $videos = Video::orderBy('created_at', 'desc')->get();
        }


        $categories = Category::where('status',1)->orderBy('name')->get();

        return view('adminCMS.videos.videos',compact('videos','categories', 'categoryId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status',1)->orderBy('name')->get();
        //dd($categories->toArray());
        return view('adminCMS.videos.addVideo',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddVideoRequest $request)
    {
        try{
            $videoFile      = $request->file('video');
            $thumbnailFile  = $request->file('thumbnail');
            $videoName      = 'video_'.str_slug($request->input('title')).".".$videoFile->getClientOriginalExtension();
            $thumbnailName  = 'thumbnail_'.str_slug($request->input('title')).".".$thumbnailFile->getClientOriginalExtension();
            $category       = Category::find($request->input('category'));
            $tags           = json_decode($request->input('tags'),true);

            if ($videoFile->move(public_path("uploads/videos/"),$videoName) &&  $thumbnailFile->move(public_path("uploads/videos/"),$thumbnailName)){
                $video = new Video();
                $video->title = ucfirst($request->input('title'));
                $video->subtitle = ucfirst($request->input('subtitle'));
                $video->description = ucfirst($request->input('description'));
                $video->duration = "1:00";
                $video->thumbnail = asset("uploads/videos/$thumbnailName");
                $video->video = asset("uploads/videos/$videoName");
                $video->user_id = Auth::id();
                $video->save();
                $video->categories()->attach($category->id);

                foreach ($tags as $key => $value) {
                    $tagName =  $tags[$key]['name'];
                    //$tags = Tag::where('name','LIKE',"%$name%")->first();
                    $tag = Tag::firstOrCreate(['name'=>$tagName]);
                    $video->tags()->attach($tag->id);
                }
                $request->session()->flash('status', true);
                $request->session()->flash('mess', "Video : '$video->title' was added successfully !!");
            }
            return redirect()->back();
        } catch(\Exception $e){
            $request->session()->flash('status', false);
            $request->session()->flash('mess', "Sorry we could not store the video");

            if($video){
              $video->categories()->detach();
              $video->delete();
            }

            Log::warning("Can not upload Video {$e->getFile()}, {$e->getLine()}, {$e->getMessage()}");
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::find($id);
       // dd($video->categories[0]->name);
        $categories = Category::where('status',1)->orderBy('name')->get();
        $tags = Tag::where('status',1)->get();
        return view('adminCMS.videos.editVideo',compact('video','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try{

            $video = Video::find($id);

            $video->title       = $request->input('title');
            $video->subtitle    = $request->input('subtitle');
            $video->description = $request->input('description');
            $category           = Category::find($request->input('category'));
            $tags               = json_decode($request->input('tags'),true);
            $video->tags()->detach(); //we need time to attach again this is why this line is here and not inmeduatly bedore attach tags
            $video->categories()->detach();
            if($request->hasFile('thumbnail')){
                $thumbnailFile  = $request->file('thumbnail');
                $thumbnailName  = 'thumbnail_'.str_slug($request->input('title')).".".$thumbnailFile->getClientOriginalExtension();
                $thumbnailFile->move(public_path("uploads/videos/"),$thumbnailName);
                $video->thumbnail = asset("uploads/videos/$thumbnailName");
            }
            if($request->hasFile('video')){
                $videoFile      = $request->file('video');
                $videoName      = 'video_'.str_slug($request->input('title')).".".$videoFile->getClientOriginalExtension();
                $videoFile->move(public_path("uploads/videos/"),$videoName);
                $video->video = asset("uploads/videos/$videoName");

            }
            $video->categories()->attach($category->id);
                foreach ($tags as $key => $value) {
                    $tagName =  $tags[$key]['name'];
                    //$tags = Tag::where('name','LIKE',"%$name%")->first();
                    $tag = Tag::firstOrCreate(['name'=>$tagName]);

                    $video->tags()->attach($tag->id);
                }
            $video->save();

            $request->session()->flash('status', true);
            $request->session()->flash('mess', "Video : '$video->title' was updated successfully !!");
            return redirect()->back();

        } catch(\Exception $e){
            $request->session()->flash('status', false);
            $request->session()->flash('mess', "Sorry we could not update the video");
            Log::warning("Can not update Video {$e->getFile()}, {$e->getLine()}, {$e->getMessage()}");
            return redirect()->back();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{

            $video = Video::find($id);

            @unlink($this->getAssetPath($video->thumbnail,'uploads'));
            @unlink($this->getAssetPath($video->video,'uploads'));
            $video->categories()->detach();
            $video->tags()->detach();
            $video->delete();
            $request->session()->flash('status', true);
            $request->session()->flash('mess', "Video : '$video->title' was deleted successfully !!");
            return redirect()->back();
        } catch(\Exception $e) {
            $request->session()->flash('status', false);
            $request->session()->flash('mess', "Sorry we could not deleted the video");
            Log::warning("Can not deleted Video {$e->getFile()}, {$e->getLine()}, {$e->getMessage()}");
            return redirect()->back();
        }

    }

    public function getAssetPath($string , $coincidence){
        $whatIWant = substr($string, strpos($string, $coincidence));
        return public_path($whatIWant);
    }
}
