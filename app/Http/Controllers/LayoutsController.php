<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Layout;
use App\Models\AdminLayout;
use App\Models\Design;
use App\Models\AdminDesign;
use App\Http\Controllers\Controller;
use Response;
use View;
use Input;
use Auth;

class LayoutsController extends Controller {

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function show($layout_id) {
      $layout = Layout::find($layout_id);
      return Response::json($layout);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function store(Request $request) {
      $layout = Layout::create($request->all());
      return Response::json($layout);
   }

   /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function createdesign(Request $request) {
      $design = Design::create($request->all());
      return Response::json($design);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $layout_id) {

      $layout = Layout::find($layout_id);

      $layout->canvas_thumbnail = $request->canvas_thumbnail;
      $layout->canvas_json = $request->canvas_json;

      $layout->save();

      return Response::json($layout);
   }

   /**
   * Upload the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function uploadlayout(Request $request, $layout_id) {
       
      $path = base_path(). '/public/uploads/layouts/';
      $relativepath = asset('uploads/layouts').'/';
      
      if(!file_exists($path)) {
         mkdir($path, 0777, true);
         chmod($path, 0777);
      }      
      
      $layout = Layout::find($layout_id);

      if($request->isTarget == 1)  {
         $img = $request->jpegimageData;
         $img = str_replace('data:image/jpeg;base64,', '', $img);
         $img = str_replace(' ', '+', $img);
         $img = base64_decode($img);

         file_put_contents($path.$layout_id.'.jpeg', $img);     
         $layout->canvas_image = $relativepath.$layout_id.'.jpeg';
      }
       
      $img = $request->pngimageData;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $img = base64_decode($img);

      file_put_contents($path.$layout_id.'.png', $img);

      file_put_contents($path.$layout_id.'.spe', $request->jsonData);

      $layout->canvas_thumbnail = $relativepath.$layout_id.'.png';
      $layout->canvas_json = $relativepath.$layout_id.'.spe';
      $layout->isTarget = $request->isTarget;
      $layout->name = $request->name;

      $layout->save();

      return Response::json($layout);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy($layout_id) {
      $layout = Layout::destroy($layout_id);
      return Response::json($layout);
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
      $spiffdesigns = Input::get('spiffdesigns');

      if($spiffdesigns) {
         
         $admindesigns = AdminDesign::where('product_id', '=', $product_id)->get();
         return View::make('getlayouts')->with(['spiffdesigns' => $admindesigns]);
      } else {

         $designs = Design::where('product_id', '=', $product_id)->get();
         return View::make('getlayouts')->with(['userdesigns' => $designs]);
      }      
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
      
      $layouts = Layout::where('design_id', '=', $design_id)->get();

      return View::make('getlayoutsrc')->with(['layouts' => $layouts]);
   }

   public function savecropimage(Request $request)
   {       
      $path = base_path().'/public/uploads/croppedimages/';
      
      if(!file_exists($path)) {
         mkdir($path, 0777, true);
         chmod($path, 0777);
      }
       
      $img = $request->pngimageData; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $img = base64_decode($img);

      file_put_contents($path.$request->filename, $img);

      return Response::json("");
   }
}
