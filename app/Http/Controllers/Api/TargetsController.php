<?php

namespace App\Http\Controllers\Api;

use App\Models\Resource;
use App\Models\Target;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TargetsController extends Controller
{
    public function show($targetId)
    {
        $target = Target::where('targetId',$targetId)->first();
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
}
