<?php

namespace App\Http\Controllers\Landing;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VideosController extends Controller
{
    public function __construct()
    {
        $this->middleware('isUser')->only('rate');
    }

    public function index()
    {
        $categories = Category::where('status',1)->orderBy('name')->get();
//        dd($categories[0]->videos->toArray()[0]);
        return view('landing.learn.learn',compact('categories'));
    }

    public function show($videoId)
    {
        $video = Video::find($videoId);
        $category = Category::find($video->categories[0]->id);
        $videosRelated = $category->videos->toArray();
        if (count($videosRelated)>5){
            $videosRelated = array_slice($videosRelated,0,5);
        }
        return view('landing.learn.video',compact('video','videosRelated'));
    }

    public function rate(Request $request)
    {
        $user = Auth::user();

        $rate = $request->input('rate');
        $videoId = $request->input('videoId');

        $video = Video::find($videoId);
        if ($user->rates->contains($video->id)){ //checking if user already vote
            return response()->json([
                'status'=>false,
                'mess'  => 'You already vote :)'
            ]);
        }
        $user->rates()->attach($video->id);

        $newRate = $video->rate($rate); //save rating an numVotes

        return response()->json([
            'status'=>true,
            'rate'  => $newRate
        ]);
    }

    public function search(Request $request)
    {
        $criteria = $request->input('criteria');
        $criteria = $this->multiexplode(array(","," ","#"), $criteria);
        $tags = [];
        $tagsFound = [];
        $videos = collect([]);
        //tags that really exist
        foreach ($criteria as $tagname) {
            $tagsResult = Tag::where('name',"$tagname")->get();
            if (count($tagsResult)==0)continue;
            foreach ($tagsResult as $tag) {
                array_push($tags,$tag);
                array_push($tagsFound,$tag->name);
            }
        }
        foreach ($tags  as $tag){
            foreach ($tag->videos as $video) {
                $videos->push($video);
            }
        }
        $uniqueVideos = $videos->unique('id'); //removing duplocated elements
        $tagsStr = implode(" #", $tagsFound);
        //dd($criteria,$tags,$videos,$videosUnique);
        return view('landing.learn.search', compact('uniqueVideos','tagsStr'));
    }

    public function viewVideo(Request $request)
    {
        $videoId = $request->input('videoId');
        $video = Video::find($videoId);
        $video->numViews = intval($video->numViews)+1;
        $video->save();

        return response()->json([
            'status'=>true,
            'rate'  => $video->numViews
        ]);
    }
    private function multiexplode ($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }



}
