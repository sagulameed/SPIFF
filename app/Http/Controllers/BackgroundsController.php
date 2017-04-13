<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Background;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class BackgroundsController extends Controller {
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index() 
   {   
      $backgrounds = Background::all();

      return view('adminCMS/backgrounds')->with(['backgrounds' => $backgrounds]);
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

      $files = Input::file('backgrounds');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/backgrounds/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $background = new Background();
         $background->background_name = asset('adminCMS/uploads/backgrounds')."/".$filename;
         $background->save();
      }

     $backgrounds = Background::all();

      return view('adminCMS/backgrounds')->with(['backgrounds' => $backgrounds, 'success' => 'Uploaded successfully']);
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
       $background = Background::find($id);

      $background->price = $request->price;

      $background->save();

      return Response::json($background);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {      
      $background = Background::destroy($id);
      return Response::json($background);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
     $background = Background::find($id);
      return view('adminCMS/editbackgrounds')->with(['background' => $background]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {

      $backgrounds = Background::where('background_name', 'LIKE', '%'.$search_input.'%')->get();;

      return View::make('adminCMS/backgrounds')->with(['backgrounds' => $backgrounds]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function searchbackgrounds($search_input)
   {
      if($search_input == "all") {
         $backgrounds = Background::all();
      } else {         
         $backgrounds = Background::whereHas('tags', function($q) use ($search_input)
         {
             $q->where('name', 'LIKE', '%'.$search_input.'%');
         })->get();
      }

      return View::make('getBackgrounds')->with(['backgrounds' => $backgrounds]);
   }
}