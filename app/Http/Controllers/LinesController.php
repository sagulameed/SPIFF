<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Line;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class LinesController extends Controller {
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index() 
   {
      $lines = Line::all();

      return view('adminCMS/lines')->with(['lines' => $lines]);
   }
    /**
   * Show the form for creating a new resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
   public function create(Request $request)
   {
      //Input::file('photo')->move($destinationPath, $fileName);

      $files = Input::file('lines');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/lines/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $line = new Line();
         $line->line_name = asset('adminCMS/uploads/lines')."/".$filename;
         $line->save();
      }

      $lines = Line::all();

      return view('adminCMS/lines')->with(['lines' => $lines, 'success' => 'Uploaded successfully']);
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
      $line = Line::find($id);

      $line->price = $request->price;

      $line->save();

      return Response::json($line);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {
      $line = Line::destroy($id);
      return Response::json($line);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $line = Line::find($id);
      return view('adminCMS/editlines')->with(['line' => $line]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {

      $lines = Line::where('line_name', 'LIKE', '%'.$search_input.'%')->get();;

      return View::make('adminCMS/lines')->with(['lines' => $lines]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function searchlines($search_input)
   {
      if($search_input == "all") {
         $lines = Line::all();
      } else {      
         $lines = Line::whereHas('tags', function($q) use ($search_input)
         {
             $q->where('name', 'LIKE', '%'.$search_input.'%');
         })->get();
      }

      return View::make('getLines')->with(['lines' => $lines]);
   }
}





