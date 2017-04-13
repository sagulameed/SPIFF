<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Grid;
use App\Http\Controllers\Controller;
use Response;
use Input;
use View;
use Redirect;

class GridsController extends Controller {
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index() {
     $grids = Grid::all();

      return view('adminCMS/grids')->with(['grids' => $grids]);
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

      $files = Input::file('grids');
      foreach($files as $file) {
         $destinationPath = base_path() . '/public/adminCMS/uploads/grids/';
         $filename = $file->getClientOriginalName();
         $file->move($destinationPath, $filename);

         $grid = new Grid();
         $grid->grid_name = asset('adminCMS/uploads/grids')."/".$filename;
         $grid->save();
      }

      $grids = Grid::all();

      return view('adminCMS/grids')->with(['grids' => $grids, 'success' => 'Uploaded successfully']);
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
      $grid = Grid::find($id);

      $grid->price = $request->price;

      $grid->save();

      return Response::json($grid);
   }

   /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function destroy(Request $request , $id)
   {
      $grid = Grid::destroy($id);
      return Response::json($grid);
   }

   /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function edit($id)
   {
      $grid = Grid::find($id);
      return view('adminCMS/editgrids')->with(['grid' => $grid]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function search($search_input)
   {

      $grids = Grid::where('grid_name', 'LIKE', '%'.$search_input.'%')->get();;

      return View::make('adminCMS/grids')->with(['grids' => $grids]);
   }
   /**
   * Search for the specified resource.
   *
   * @param  string  $search_input
   * @return \View
   */
   public function searchgrids($search_input)
   {
      if($search_input == "all") {
         $grids = Grid::all();
      } else {         
         $grids = Grid::whereHas('tags', function($q) use ($search_input)
         {
             $q->where('name', 'LIKE', '%'.$search_input.'%');
         })->get();
      }

      return View::make('getGrids')->with(['grids' => $grids]);
   }
}
   
