<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AdminLayout;
use App\Models\AdminDesign;
use App\Http\Controllers\Controller;
use Response;
use View;
use Input;

class AdminLayoutsController extends Controller {

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show($layout_id) {
      $adminlayout = Adminlayout::find($layout_id);
      return Response::json($adminlayout);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function createdesign(Request $request) {
      $admindesign = AdminDesign::create($request->all());
      return Response::json($admindesign);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request) {
      $adminlayout = AdminLayout::create($request->all());
      return Response::json($adminlayout);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $layout_id) {

      $adminlayout = Adminlayout::find($layout_id);

      $adminlayout->canvas_thumbnail = $request->canvas_thumbnail;
      $adminlayout->canvas_json = $request->canvas_json;
      $adminlayout->product_id = $request->product_id;

      $adminlayout->save();

      return Response::json($adminlayout);
   }

   /**
   * Upload the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function uploadAdminlayout(Request $request, $layout_id) {
       
      $path = base_path(). '/public/adminCMS/uploads/layouts/';
      $relativepath = asset('adminCMS/uploads/layouts').'/';
      
      if(!file_exists($path)) {
         mkdir($path, 0777, true);
         chmod($path, 0777);
      }      
      
      $adminlayout = Adminlayout::find($layout_id);

      if($request->isTarget == 1)  {
         $img = $request->jpegimageData;
         $img = str_replace('data:image/jpeg;base64,', '', $img);
         $img = str_replace(' ', '+', $img);
         $img = base64_decode($img);

         file_put_contents($path.$layout_id.'.jpeg', $img);     
         $adminlayout->canvas_image = $relativepath.$layout_id.'.jpeg'; 
      }
       
      $img = $request->pngimageData;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $img = base64_decode($img);

      file_put_contents($path.$layout_id.'.png', $img);       
      file_put_contents($path.$layout_id.'.spe', $request->jsonData);

      $adminlayout->canvas_thumbnail = $relativepath.$layout_id.'.png';
      $adminlayout->canvas_json = $relativepath.$layout_id.'.spe';
      $adminlayout->isTarget = $request->isTarget;
      $adminlayout->name = $request->name;

      $adminlayout->save();

      return Response::json($adminlayout);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroylayout($layout_id) {

      $path = base_path(). '/public/adminCMS/uploads/layouts/';

      @unlink($path.$layout_id.'.jpeg');
      @unlink($path.$layout_id.'.png');
      @unlink($path.$layout_id.'.spe');

      $adminlayout = Adminlayout::destroy($layout_id);
      return Response::json($adminlayout);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroydesign($adminDesign_id) {
      
      $adminlayouts = AdminLayout::where('adminDesign_id', '=', $adminDesign_id)->get();

      foreach($adminlayouts as $adminlayout) {
         $this->destroylayout($adminlayout->id);
      }

      $admindesign = AdminDesign::destroy($adminDesign_id);
      return Response::json($admindesign);
   }

   /**
   * Get all layouts.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function getlayouts()
   {
      $product_id = Input::get('product_id');
      $admindesigns = AdminDesign::where('product_id', '=', $product_id)->get();

      return View::make('getlayouts')->with(['spiffdesigns' => $admindesigns]);
   }

   /**
   * Get all admin layouts.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function getlayoutsrc()
   {
      $design_id = Input::get('design_id');
      
      $adminlayouts = AdminLayout::where('adminDesign_id', '=', $design_id)->get();

      return View::make('getlayoutsrc')->with(['adminlayouts' => $adminlayouts]);
   }

   // function to save the cropped images.
   public function savecropimage(Request $request)
   {       
      $path = base_path().'/public/adminCMS/uploads/croppedimages/';
      
      if(!file_exists($path)) {
         mkdir($path, 0777, true);
         chmod($path, 0777);
      }
       
      $img = $request->pngimageData;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $img = base64_decode($img);

      file_put_contents($path.$request->filename, $img);

      return Response::json("");
   }
}