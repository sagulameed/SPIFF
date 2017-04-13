<?php

namespace App\Http\Controllers\Landing;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscoverController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->get();


        return view('landing.discover.products',compact('products'));
    }

    public function show($productId)
    {
        $product = Product::find($productId);
        $product->numViews += 1;
        $product->save();
        return view('landing.discover.product', compact('product'));
    }
}
