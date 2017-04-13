<?php

namespace App\Http\Controllers\Api;

use App\Models\Resource;
use App\Models\Target;
use FFMpeg\Exception\RuntimeException;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ResourceController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');

    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $targetId = $request->input('targetId');

        $target = Target::find($targetId);
        if (!$target){
            return response()->json(['error'=>'target not found'],404);
        }
        $video = Resource::where('target_id',$target->id)->where('type','video')->first();
        $images = Resource::where('target_id',$target->id)->where('type','image')->get();

        if (count($video)>0){
            $video = ['video'=>$video->toArray()];
        }else{
            $video=[];
        }

        if (count($images) > 0){
            $images = ['images'=>$images->toArray()];
        }else{
            $images=[];
        }

        $resources = array_merge($video, $images);

        return response()->json($resources, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
//            dd($request->all());
            $user           = $request->user();
            $resourceFile   = $request->file('resource');
            $type           = $request->input('type');
            $fileName       = $request->input('fileName');
            $orientation    = $request->input('orientation');
            $extension      = ($type=='video')?'mp4':'jpg';
            $target         = Target::find($request->input('targetId'));
            $os             = $request->input('os');
            Log::info('File Name:'.$fileName);
            Log::info('File Extension:'.$extension);
            Log::info('File type:'.$type);


            if (!$target){
                return response()->json(['status'=>false, 'mess'=>'Target not found'], 404);
            }

            $resourceName  = $type.'_'.str_random(20).".".$extension;
            $resourceFile->move(public_path("uploads/targets/"), $resourceName);
            $resource = $target->resources()->create([
                'resource'  => asset('uploads/targets/'.$resourceName),
                'thumbnail' => '',
                'orientation' => $orientation,
                'type'      => $type,
            ]);
            Log::info('Resource created');
            Log::info('Resource Name:'.$resourceName);

            if($extension == 'jpg'){
                Log::info('Creating image');
                $imgIntervention = Image::make(public_path("uploads/targets/$resourceName"));
                $imgIntervention->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path("uploads/targets/thumb_$resourceName"));

                $resource->thumbnail = asset("uploads/targets/thumb_$resourceName");
                $resource->save();
                Log::info('Finish Thumbnail');
            } elseif($extension == 'mp4' && $os == 'ios'){
                Log::info('coding video:'.$resourceName);
                $path = "uploads/targets/$resourceName";
                $codecName = $this->codecVideo($path);
                $resource->resource = asset("uploads/targets/$codecName");
                $resource->save();
                @unlink(public_path("uploads/targets/$resourceName"));

            }


            return response()->json([
                'status'=>true,
                'mess'=>'Image updated successfully',
                'resource' => $resource->thumbnail,
                'orientation' => $orientation,
                'id' => $resource->id,
            ], 200);

        } catch (RuntimeException $e){
            Log::info("Run time exception :::::::{$e->getMessage()},
            {$e->getFile()},
            {$e->getLine()},
            {$e->getCode()}:::::::
            {$e->getPrevious()},
            {$e->getTraceAsString()}");

            return response()->json([
                'status'=>false,
                'message' => 'Service not available'
            ]);
        } catch (\Exception $e){
            Log::info("Error uploading image {$e->getMessage()},{$e->getFile()},{$e->getLine()}");
            return response()->json(['status'=>false, 'mess'=>'Something bad happened','mess'=>$e->getMessage()], 500);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            Log::info('Andre sent me :'. $id );

//            $extension = $request->header('Content-Type');
            $resourceFile   = $request->file('resource');
            $resource       = Resource::find($id);
            $orientation    = $request->input('orientation');
            $os             = $request->input('os');

            if (!$resource){
                return response()->json(['status'=>false, 'mess'=>'Resource not found'], 404);
            }

            $extension =($resource->type=='video')?'mp4':'jpg';

            $resourceName  = $resource->type.'_'.str_random(20).'.'.$extension;

            Log::info('resource Name:'. $resourceName);
//            file_put_contents(public_path("uploads/targets/$resourceName"),$resourceFile);
            $resourceFile->move(public_path("uploads/targets/"),$resourceName);

            $resource->resource = asset('uploads/targets/'.$resourceName);
            $resource->orientation = $orientation;

            if($extension == 'jpg'){

                @unlink(Resource::getPublicPath($resource->thumbnail,'uploads'));

                $imgIntervention = Image::make(public_path("uploads/targets/$resourceName"));
                $imgIntervention->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $imgIntervention->save(public_path("uploads/targets/thumb_$resourceName"));

                $resource->thumbnail = asset("uploads/targets/thumb_$resourceName");

            } elseif ($extension == 'mp4' && $os == 'ios'){
                Log::info('coding video:'.$resourceName);
                $path = "uploads/targets/$resourceName";
                $codecName = $this->codecVideo($path);
                $resource->resource = asset("uploads/targets/$codecName");

                @unlink(public_path("uploads/targets/$resourceName"));
            }
            $resource->save();

            return response()->json([
                'status'=>true,
                'mess'=>'Resource updated successfully',
                'resource' => $resource->resource,
                'orientation' => $orientation,
                'id' => $resource->id
            ], 200);

        } catch (RuntimeException $e){
            Log::info("Run time exception :::::::{$e->getMessage()},
            {$e->getFile()},
            {$e->getLine()},
            {$e->getCode()}:::::::
            {$e->getPrevious()},
            {$e->getTraceAsString()}");

            return response()->json([
                'status'=>false,
                'message' => 'Service not available'
            ]);
        } catch (\Exception $e){
            Log::info("Error uploading resource {$e->getMessage()},{$e->getLine()}");
            return response()->json(['status'=>false, 'mess'=>'Something bad happened','mess'=>$e->getMessage()], 500);
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function codecVideo($path)
    {
        /*Decoding video for android*/
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => env('FFMPG'),
            'ffprobe.binaries' => env('FFPROBE'),
            'timeout'          => 9800, // The timeout for the underlying process
            'ffmpeg.threads'   => 1
        ]);
        Log::info('starting open video');
//
        $videoCodec = $ffmpeg->open(public_path($path));
        $format = new X264();
        $format->setAudioCodec('libmp3lame');
        Log::info('coding audio');
        $codecName ="export_".str_random(20).".mp4";
        $newVideoPath = public_path("uploads/targets/$codecName");
        $videoCodec->save($format, $newVideoPath);
        Log::info('video coding finish');

        return $codecName;
    }
}
