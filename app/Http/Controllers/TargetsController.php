<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Resource;
use App\Models\Target;
use FFMpeg\Exception\RuntimeException;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;


class TargetsController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        try {

            $design = Design::find($request->input('designId'));

            $target = $design->target;
//            $target->image='path to image';
          /*  $target->targetId=$request->input('targetId');
//            $target->user_id= Auth::user()->id;
            $target->save();*/

            if($request->hasFile('video')){
                $videoFile      = $request->file('video');
                $videoName      = 'video_'.str_random(20).".".$videoFile->getClientOriginalExtension();
                $videoFile->move(public_path("uploads/targets/"),$videoName);
                $resource = new Resource();
                $resource->resource =asset('uploads/targets/'.$videoName);
                $resource->type ='video';
                $resource->target_id=$target->id;
                $resource->save();

                $path = "uploads/targets/$videoName";
                $codecName = $this->codecVideo($path);
                @unlink(public_path('uploads/targets/'.$videoName));
                //save database
                $resource->resource = asset("uploads/targets/$codecName");
                $resource->save();
            }
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach ($images as $image){

                    $imageFile      = $image;
                    $imageName      = 'image_'.str_random(20).".".$imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path("uploads/targets/"),$imageName);
                    $resource = new Resource();
                    $resource->resource =asset('uploads/targets/'.$imageName);
                    $resource->thumbnail = '';
                    $resource->type ='image';
                    $resource->target_id=$target->id;
                    $resource->save();

                    $imgIntervention = Image::make(public_path("uploads/targets/$imageName"));
                    $imgIntervention->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $imgIntervention->save(public_path("uploads/targets/thumb_$imageName"));
                    $resource->thumbnail =asset("uploads/targets/thumb_$imageName");
                    $resource->save();
                }
            }

            /*$design->target_id = $target->id;
            $design->save();*/


//            Log::info("target added"+$target->id);
            return response()->json([
                'status'=>true,
                'mess' => 'Target Media set correctly'
            ]);
        } catch (\Exception $e){

            Log::info("Error uploading target {$e->getMessage()},{$e->getLine()}");
            return response()->json([
                'status'=>false,
                'message' => 'Target media did not set correctly'
            ]);
        }

    }


    public function updateVideo(Request $request)
    {
        try{
            if (!$request->hasFile('video')){
                return response()->json([
                    'status'=>false,
                    'mess' => 'Video file is missing'
                ]);
            }


            $video      = Resource::find($request->input('videoId'));
            $videoFile  = $request->file('video');

            @unlink(Resource::getPublicPath($video->resource,'uploads'));

            $videoName      = 'video_'.str_random(20).".".$videoFile->getClientOriginalExtension();
            $videoFile->move(public_path("uploads/targets/"),$videoName);
            $video->resource =asset('uploads/targets/'.$videoName);
            $video->save();

            $path = "uploads/targets/$videoName";

            $codecName = $this->codecVideo($path);

            //save database
            $video->resource = asset("uploads/targets/$codecName");
            $video->save();
            @unlink(public_path("uploads/targets/$videoName"));
            return response()->json([
                'status'=>true,
                'mess' => 'Video Updated successfully',
                'url' => asset("uploads/targets/$codecName")
            ]);

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
        }
        catch (\Exception $e){

            Log::info("Error uploading Video:::::::{$e->getMessage()},{$e->getFile()},{$e->getLine()},{$e->getCode()}:::::::{$e->getTraceAsString()}");
            return response()->json([
                'status'=>false,
                'message' => 'Service not available'
            ]);
        }

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

        $videoCodec = $ffmpeg->open(public_path($path));
        $format = new X264();
        $format->setAudioCodec('libmp3lame');
        Log::info('coding audio');
        $codecName ="export_".str_random(20).".mp4";
        $newVideoPath = public_path("uploads/targets/$codecName");
        $videoCodec->save($format,$newVideoPath);
        Log::info('video coding finish');

        return $codecName;
    }

    public function imageRemove(Request $request)
    {
//        dd($request->all());

        $image = Resource::find($request->input('imgId'));

        @unlink(Resource::getPublicPath($image->resource,'uploads'));
        @unlink(Resource::getPublicPath($image->thumbnail,'uploads'));

        $image->delete();

        return response()->json([
            'status'=>true,
            'mess' => 'Image Removed successfully'
        ]);


    }

    public function images(Request $request)
    {
//        dd($request->all());

        if(!$request->hasFile('images')){
            return response()->json([
                'status'=>false,
                'mess' => 'No images were uploaded'
            ]);
        }

        $images = $request->file('images');
        $target = Target::find($request->input('targetId'));
        foreach ($images as $image){
            $imageFile      = $image;
            $imageName      = 'image_'.str_random(20).".".$imageFile->getClientOriginalExtension();
            $imageFile->move(public_path("uploads/targets/"),$imageName);

            $resource = new Resource();
            $resource->resource =asset('uploads/targets/'.$imageName);
            $resource->type ='image';
            $resource->target_id = $target->id;


            $imgIntervention = Image::make(public_path("uploads/targets/$imageName"));
            $imgIntervention->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $imgIntervention->save(public_path("uploads/targets/thumb_$imageName"));
            $resource->thumbnail =asset("uploads/targets/thumb_$imageName");
            $resource->save();

        }

        return response()->json([
            'status'=>true,
            'mess' => 'Images uploaded successfully'
        ]);
    }

}
