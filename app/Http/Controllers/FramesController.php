<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Frame;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class FramesController extends Controller {
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index() {
      $frames = Frame::all();

      return view('adminCMS/frames')->with(['frames' => $frames]);
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

      $files = Input::file('frames');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/frames/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $frame = new Frame();
         $frame->frame_name = asset('adminCMS/uploads/frames')."/".$filename;
         $frame->save();
      }

      $frames = Frame::all();

      return view('adminCMS/frames')->with(['frames' => $frames, 'success' => 'Uploaded successfully']);
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

      $frame = Frame::find($id);

      $frame->price = $request->price;

      $frame->save();

      return Response::json($frame);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {
      $frame = Frame::destroy($id);
      return Response::json($frame);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
       $frame = Frame::find($id);
      return view('adminCMS/editframes')->with(['frame' => $frame]);
   }

   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {

      $frames = Frame::where('frame_name', 'LIKE', '%'.$search_input.'%')->get();;

      return View::make('adminCMS/frames')->with(['frames' => $frames]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function searchframes($search_input)
   {
      if($search_input == "all") {
         $frames = Frame::all();
      } else {      
         $frames = Frame::whereHas('tags', function($q) use ($search_input)
         {
             $q->where('name', 'LIKE', '%'.$search_input.'%');
         })->get();
      }

      return View::make('getFrames')->with(['frames' => $frames]);
   }
}
   

