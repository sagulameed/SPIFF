<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Product;
use App\Models\AdminDesign;
use App\Models\AdminLayout;
use Redirect;
use View;
use Input;

class ProductLayoutsController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $products = Product::all();

      return view('adminCMS/productlayouts')->with(['products' => $products]);
   }

   public function editdesigns($product_id)
   {
      $admindesigns = AdminDesign::where('product_id', '=', $product_id)->get();
      $product = Product::find($product_id);
      
      return view('adminCMS/editdesigns')->with(['admindesigns' => $admindesigns, 'product' => $product]);
   }

   public function editlayouts()
   {
      $product_id = Input::get('product_id');
      $admin_layouts = AdminLayout::where('product_id', '=', $product_id)->get();
      
      return view('adminCMS/editlayouts')->with(['layouts' => $admin_layouts, 'product_id' => $product_id]);
   }
   
}

