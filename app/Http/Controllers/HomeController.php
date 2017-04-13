<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Video;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products   = Product::orderBy('created_at','desc')->take(20)->get();
        $videos     = Video::orderBy('numViews')->take(20)->get();
        $gallery    = DB::table('shares')
            ->join('share_like','shares.id','=','share_like.share_id')
            ->join('designs','designs.id','=','shares.design_id')
            ->join('layouts','designs.id','=','layouts.design_id')
            ->select('share_id', DB::raw('count(*) as total'),'designs.name as designName','designs.id as designId','layouts.canvas_thumbnail')
            ->where('shares.status','approved')
            ->groupBy('share_id')->take(20)
            ->get();
      //  dd($videos,$products);
        return view('home',compact('products','videos','gallery'));
    }
}
