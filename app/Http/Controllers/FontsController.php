<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Font;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class FontsController extends Controller {

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {
      $fonts = Font::all();

      return view('adminCMS/fonts')->with(['fonts' => $fonts]);
   }

   /**
   * Show the form for creating a new resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function create(Request $request)
   {
      $files = Input::file('fonts');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/fonts/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $font = new Font();
         $font->font_name = $filename;
         $font->save();
      }

      $fonts = Font::all();

      return view('adminCMS/fonts')->with(['fonts' => $fonts, 'success' => 'Uploaded successfully']);
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
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {
      $font = Font::destroy($id);
      return Response::json($font);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {

      $fonts = Font::where('font_name', 'LIKE', '%'.$search_input.'%')->get();;

      return View::make('adminCMS/fonts')->with(['fonts' => $fonts]);
   }
}