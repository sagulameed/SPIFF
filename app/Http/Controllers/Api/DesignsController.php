<?php

namespace App\Http\Controllers\Api;

use App\Models\Design;
use App\Models\Resource;
use App\Models\Target;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DesignsController extends Controller
{
    public function creations(Request $request)
    {
        try{
            $user = $request->user();
            $creationsResp['data'] = [];
            $creations = $user->designs;
            foreach ($creations as $creation) {

                if (!empty($creation->target_id)){
                    $arr = [];
                    $arr['name']        = $creation->name;
                    $arr['thumbnail']   = $creation->layouts()->where('isTarget',1)->first()->canvas_thumbnail;
                    $arr['targetId']    = $creation->target_id;

                    array_push($creationsResp['data'] , $arr);
                }

            }

            return response()->json($creationsResp);
        } catch(\Exception $e){
            Log::info("Error givign designs {$e->getMessage()},{$e->getLine()}");
            return response()->json([
                'status'=>false,
                'mess'=>'Something bad happened:'. $e->getMessage().$e->getLine()
            ],500);
        }
    }

    /*public function resources(Request $request)
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
    }*/

    public function images(Request $request)
    {

    }



}
