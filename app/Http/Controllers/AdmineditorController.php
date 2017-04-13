<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Redirect;
use App\Models\AdminDesign;
use App\Models\AdminLayout;
use App\Models\Illustration;
use App\Models\Line;
use App\Models\Frame;
use App\Models\Grid;
use App\Models\Picture;
use App\Models\Background;
use App\Models\Product;
use App\Models\Panel;
use App\Models\Font;
use View;
use Input;
use Response;

class AdmineditorController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function createdesign($product_id)
   {
      return $this->editdesign($product_id, '');
   }
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function editdesign($product_id, $adminDesign_id)
   {
   
      $admin_layouts = [];

      $theDesign = '';   
      if($adminDesign_id){
            $admin_layouts = AdminLayout::where('adminDesign_id', '=', $adminDesign_id)->get();
            $theDesign  = AdminDesign::find($adminDesign_id);
      }

      $illustrations = Illustration::whereNull('product_id')->get();
      $recillustrations = Illustration::where('product_id', '=', $product_id)->get();

      $lines = Line::all();
      $fonts = Font::all();
      $frames = Frame::all();
      $grids = Grid::all();
      $pictures = Picture::all();
      $backgrounds = Background::all();
      $products = Product::all();

      $admindesigns = AdminDesign::where('product_id', '=', $product_id)->get();

      $panels = Panel::where('product_id', '=', $product_id)->get();

      $panel_id = Input::get('panel_id');
      if($panel_id != "")
         $panel = Panel::find($panel_id);
      else {
         $panel = $panels[0];
      }

      return View::make('welcome')->with(['adminlayouts' => $admin_layouts, 'illustrations' => $illustrations, 'recillustrations' => $recillustrations, 'lines' => $lines, 'frames' => $frames, 'grids' => $grids, 'pictures' => $pictures, 'backgrounds' => $backgrounds, 'products' => $products, 'product_id' => $product_id, 'panel' => $panel, 'panels' => $panels, 'admindesigns' => $admindesigns, 'fonts' => $fonts, 'theDesign' => $theDesign]);
   }

   public function designlayouts($adminDesign_id) {
      $adminlayouts = AdminLayout::where('adminDesign_id', '=', $adminDesign_id)->get();
      return Response::json($adminlayouts);
   }
}