<?php

namespace App\Http\Controllers\AdminCMS;

use App\Models\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function index()
    {
        $shares = Share::where('status','evaluating')->get();

        return view('adminCMS.gallery.gallery',compact('shares'));
    }

    public function statusGallery(Request $request)
    {
        $share = Share::where('id',$request->input('shareId'))->first();
        $sentence = filter_var($request->input('statusAprove'), FILTER_VALIDATE_BOOLEAN);
        $status = ($sentence)?'approved':'rejected';
        $share->status = $status;
        $share->save();
        $request->session()->flash('status', true);
        $request->session()->flash('mess', "Success changed to $status");
        return redirect()->back();
    }
}
