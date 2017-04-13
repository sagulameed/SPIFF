<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;

class PublishController extends Controller
{
    public function spiff(Request $request)
    {
        $design = Design::find($request->input('designId'));

        if($design->share){

            $share = $design->share;
            $share->update([
                'status'=>'evaluating'
            ]);

        }
        else{
            $share = $design->share()->create([
                'status'=>'evaluating'
            ]);
        }
        return response()->json([
            'status'=> true,
            'mess'=> 'Your Share is in revision please hold on until it is approved or rejected'
        ]);
    }
}
