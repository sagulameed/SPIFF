<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Illustration;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class IllustrationsController extends Controller {
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index() 
   {
      $illustrations = Illustration::where('product_id', '=', null)->get();

      return view('adminCMS/illustrations')->with(['illustrations' => $illustrations]);
   }
    /**
   * Show the form for creating a new resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function create(Request $request)
   {
      $files = Input::file('illustrations');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/illustrations/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $illustration = new Illustration();
         $illustration->image = asset('adminCMS/uploads/illustrations')."/".$filename;
         $illustration->save();
      }

      $illustrations = Illustration::where('product_id', '=', null)->get();

      return view('adminCMS/illustrations')->with(['illustrations' => $illustrations, 'success' => 'Uploaded successfully']);
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $idte
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, $id)
   {

      $illustration = Illustration::find($id);

      $illustration->price = $request->price;

      $illustration->save();

      return Response::json($illustration);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {
      $illustration = Illustration::destroy($id);
      return Response::json($illustration);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $illustration = Illustration::find($id);
      return view('adminCMS/editillustrations')->with(['illustration' => $illustration]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {
      $illustrations = Illustration::where('name', 'LIKE', '%'.$search_input.'%')->get();

      return View::make('adminCMS/illustrations')->with(['illustrations' => $illustrations]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function searchillustrations($search_input)
   {
      if($search_input == "all") {
         $illustrations = Illustration::all();
      } else {      
         $illustrations = Illustration::whereHas('tags', function($q) use ($search_input)
         {
             $q->where('name', 'LIKE', '%'.$search_input.'%');
         })->get();
      }

      return View::make('getIllustrations')->with(['illustrations' => $illustrations]);
   }
}
