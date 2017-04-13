<?php

namespace App\Http\Controllers\Landing;

use App\Models\Share;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{


    public function __construct()
    {
        $this->middleware('isUser')->only(['comment','like']);
    }

    public function index()
    {
        $shares = Share::where('status','approved')->get();

        return view('landing.gallery.gallery',compact('shares'));
    }

    public function comment(Request $request)
    {

        $shareId = Share::find($request->input('shareId'));
        $comment = $request->input('comment');

        $user = Auth::user();

        $user->commentsShare()->attach($shareId, ['comment' => $comment]);


        return response()->json([
            'status'=>true,
            'mess'  => 'comment done'
        ]);


    }

    public function like(Request $request)
    {
        $user = Auth::user();
        $share = Share::find($request->input('shareId'));

        if ($user->likesShare->contains($share->id)){ //checking if user already like it

            $user->likesShare()->detach($share->id);

            return response()->json([
                'status'=>false,
                'mess'  => 'Dislike this share'
            ]);
        }
        $user->likesShare()->attach($share->id);


        return response()->json([
            'status'=>true,
            'mess'  => 'like it'
        ]);
    }

}
