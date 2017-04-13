<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layout;
use App\Models\AdminLayout;
use App\Models\Design;
use App\Models\AdminDesign;
use App\Models\Illustration;
use App\Models\Line;
use App\Models\Frame;
use App\Models\Grid;
use App\Models\Font;
use App\Models\Picture;
use App\Models\Background;
use App\Models\Product;
use App\Models\Panel;
use App\Models\UserImage;

use View;
use Input;
use Auth;
use Redirect;
use Response;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	public function editdesign($product_id, $design_id)
	{
		return $this->edit($product_id, $design_id, '', '');
	}

	public function editadmindesign($product_id, $adminDesign_id)
	{
		return $this->edit($product_id, '', $adminDesign_id, '');
	}

	public function editpanel($product_id, $panel_id)
	{
		return $this->edit($product_id, '', '', $panel_id);
	}

	private function edit($product_id, $design_id, $adminDesign_id, $panel_id) {
		if(Auth::guest()) {
			return redirect()->guest('login');
		}
		if(Auth::user()->isAdmin()) {
			return Redirect::to('adminCMS/products');
		}

        $layouts = [];
        $theDesign = '';   
		if($design_id){
            $layouts    = Layout::where('design_id', '=', $design_id)->get();
            $theDesign  = Design::find($design_id);
        }
   
		if($adminDesign_id){
            $layouts    = AdminLayout::where('adminDesign_id', '=', $adminDesign_id)->get();
        }

      	$illustrations = Illustration::whereNull('product_id')->get();
      	$recillustrations = Illustration::where('product_id', '=', $product_id)->get();
		$lines = Line::all();
		$frames = Frame::all();
		$grids = Grid::all();
		$fonts = Font::all();
		$pictures = Picture::all();
		$backgrounds = Background::all();
		$products = Product::all();
				
		$userimages = UserImage::where('user_id', '=', Auth::id())->get();
		
		$designs = Design::where('product_id', '=', $product_id)->get();

		$admindesigns = AdminDesign::where('product_id', '=', $product_id)->get();
		$adminlayouts = [];

		$panels = Panel::where('product_id', '=', $product_id)->get();

		if($panel_id != "")
			$panel = Panel::find($panel_id);
		else {
			$panel = $panels[0];
		}

		return View::make('welcome')->with(['adminlayouts' => $adminlayouts, 'layouts' => $layouts, 'illustrations' => $illustrations, 'recillustrations' => $recillustrations, 'lines' => $lines, 'frames' => $frames, 'grids' => $grids, 'pictures' => $pictures, 'backgrounds' => $backgrounds, 'products' => $products, 'fonts' => $fonts, 'product_id' => $product_id, 'userimages' => $userimages, 'panel' => $panel, 'designs' => $designs, 'admindesigns' => $admindesigns, 'panels' => $panels, 'theDesign'=> $theDesign, 'adminDesign_id'=> $adminDesign_id]);

	}

	public function uploaduserimages(Request $request)
	{

		$imagefile = Input::file('importfile');
		$destinationPath = base_path(). '/public/uploads/userimages/';
		$relativepath = 'uploads/userimages/';
		if(!file_exists($destinationPath)) {
		 mkdir($destinationPath, 0777, true);
		 chmod($destinationPath, 0777);
		}      
		if($imagefile != "") {
			$filename = $imagefile->getClientOriginalName();
			$imagefile->move($destinationPath, $filename);
			$userimage = new UserImage();
			$userimage->image_name = $filename;
			$userimage->user_id = Auth::id();
			$userimage->save();
		}

      	return Response::json("");
	}

	public function saveuserimages(Request $request)
	{
		$img = $request->user_image;
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$img = base64_decode($img);

		$destinationPath = base_path(). '/public/uploads/userimages/';
		$relativepath = 'uploads/userimages/';
		if(!file_exists($destinationPath)) {
		 mkdir($destinationPath, 0777, true);
		 chmod($destinationPath, 0777);
		}
		$filename = $request->filename;
  		file_put_contents($destinationPath.$filename, $img);
		$userimage = new UserImage();
		$userimage->user_id = Auth::id();
		$userimage->image_name = $filename;
		$userimage->save();

      	return Response::json("");
	}

	public function getuserimages(Request $request)
	{
      	$user_id = Input::get('user_id');
		$userimages = UserImage::where('user_id', '=', $user_id)->get();

		return View::make('getUserImages')->with(['userimages' => $userimages]);
	}

	public function destroyuserimage(Request $request , $id)
	{
		$userimage = UserImage::destroy($id);
		return Response::json($userimage);
	}

	public function designlayouts($design_id) {
		$layouts = Layout::where('design_id', '=', $design_id)->get();
		return Response::json($layouts);
	} 

	public function admindesignlayouts($adminDesign_id) {
		$adminlayouts = AdminLayout::where('adminDesign_id', '=', $adminDesign_id)->get();
		return Response::json($adminlayouts);
	} 
}
