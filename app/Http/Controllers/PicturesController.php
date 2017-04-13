<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Picture;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class PicturesController extends Controller {
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index() {
      $pictures = Picture::all();

      return view('adminCMS/pictures')->with(['pictures' => $pictures]);
   }
   /**
   * Show the form for creating a new resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function create(Request $request)
   {
      $files = Input::file('pictures');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/pictures/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $picture = new Picture();
         $picture->picture_name = asset('adminCMS/uploads/pictures')."/".$filename;
         $picture->save();
      }
      
      $pictures = Picture::all();

      return view('adminCMS/pictures')->with(['pictures' => $pictures, 'success' => 'Uploaded successfully']);
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

      $picture = Picture::find($id);

      $picture->price = $request->price;

      $picture->save();

      return Response::json($picture);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {
      $picture = Picture::destroy($id);
      return Response::json($picture);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $picture = Picture::find($id);
      return view('adminCMS/editpictures')->with(['picture' => $picture]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {

      $pictures = Picture::where('picture_name', 'LIKE', '%'.$search_input.'%')->get();;

      return View::make('adminCMS/pictures')->with(['pictures' => $pictures]);
   }

   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function searchpictures($search_input)
   {
      if($search_input == "all") {
         $pictures = Picture::all();
      } else {         
         $pictures = Picture::whereHas('tags', function($q) use ($search_input)
         {
             $q->where('name', 'LIKE', '%'.$search_input.'%');
         })->get();
      }

      return View::make('getPictures')->with(['pictures' => $pictures]);
   }
}

