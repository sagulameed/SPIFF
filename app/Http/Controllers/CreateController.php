<?php 

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Panel;
use Auth;
use Input;
use Redirect;

class CreateController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('isUser')->only(['index','showdetails']);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $products = Product::orderBy('created_at','desc')->get();

        return view('landing.create')->with(['products' => $products]);
	}
	
	public function showdetails($id)
	{		
		$product = Product::find($id);

		$panels = Panel::where('product_id', '=', $id)->get();

		return view('productdetails')->with(['panels' => $panels, 'product' => $product]);
	}
}
