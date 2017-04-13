<?php

namespace App\Http\Controllers;

use App\Models\Design;
use App\Models\Layout;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Panoscape\Vuforia\VuforiaWebService;

class VuforiaController extends Controller
{
    private $vuforia;
    public function __construct(VuforiaWebService $vws)
    {
        $this->vuforia = $vws;
    }
    public function evaluate(Request $request)
    {
        try{
//            dd($request->all());
            $design = Design::find($request->input('designId'));

            $target = $design->target;

            $targetLayout = $design->layouts()->where('isTarget',1)->first();

            $targetPath = Design::getPublicPath($targetLayout->canvas_image,'uploads');


//            dd($targetFile);
//
            if (!$targetLayout){
                return response()->json([
                    'status' => false,
                    'mess'=>'This Product does not have Target Panel'
                ]);
            }

            Log::info('Starting');

            //if target dont exist create new one
            if (!$target){
                $response = $this->vuforia->addTarget([
                    'name' => str_random(25),
                    'width' => 320,
                    'path' => $targetPath,
                ]);
                Log::info('New target');
                $body = json_decode($response['body']);
//                Log::info('decogin body');
                Log::info('Status:'.$response['status']);

                if($response['status'] == 201){
                    $targetId = $body->target_id;
                    $tracking_rating  = $this->getRating($targetId);
                    while($tracking_rating == '-1'){
                        $tracking_rating = $this->getRating($targetId);
                    }
//                    Log::info('Rating:'+$tracking_rating);
                    $targetObj = new Target();
                    $targetObj->targetId = $targetId;
                    $targetObj->rank = $tracking_rating;
                    $targetObj->save();

                    $design->target_id = $targetObj->id;

                    $design->save();

                    return response()->json([
                        'status'    =>  true,
                        'rank'      =>  $tracking_rating,
                        'targetId'  =>  $targetId
                    ]);
                }
                else{
                    return response()->json([
                        'status'    =>  false,
                        'mess'      =>  $body->result_code
                    ]);
                }
            } else{ //target exists just find update and get again
                $targetId = $target->targetId;
                Log::info('Exiting Target: '.$target->targetId);
                $newTarget = $this->vuforia->updateTarget($targetId,['path'=>$targetPath]);

                if($newTarget['status']==200){
                    $tracking_rating  = $this->getRating($targetId);
                    while($tracking_rating == '-1'){
                        $tracking_rating = $this->getRating($targetId);
                    }
                    return response()->json([
                        'status' => true,
                        'rank'=>$tracking_rating,
                        'targetId' =>$targetId
                    ]);
                }
            }

        }catch(\Exception $e){
            Log::warning($e->getMessage().$e->getFile().$e->getLine());
                return response()->json([
                    'status' => false,
                    'mess'=>'Service not available'
                ]);
        }

    }


    public function getRating($targetId){

        $response = array();
        $responseGet = $this->vuforia->getTarget($targetId);
        $body = json_decode($responseGet['body']);
        $target_record = $body->target_record;
        if($responseGet['status'] == 200){
            $response =  $target_record->tracking_rating;
        }
        return $response;
    }
}
