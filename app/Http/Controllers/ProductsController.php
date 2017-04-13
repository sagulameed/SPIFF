<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Features;
use App\Models\Thumbnail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Panel;
use App\Models\Illustration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Response;
use Input;
use View;
use Redirect;

class ProductsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('created_at','desc')->get();

        return view('adminCMS/products')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateProductRequest $request)
    {
         //dd($request->all());
        $pricingJson = [];
        $from    = $request->input('from');
        $to      = $request->input('to');
        $price   = $request->input('price');
        $names   = $request->input('names');
        $panelsNames   = $request->input('panelsNames');
        $descriptions   = $request->input('descriptions');
        $tags    = json_decode($request->input('tags'),true);

        $product                  = new Product();
        $product->product_name    = $request->input('productname');
        $product->weight          = $request->input('weight');
        $product->pricePerWeight  = $request->input('pricePerWeight');
        $product->pricingJson     = Product::pricingJson($from, $to, $price);
        $product->user_id         = Auth::user()->id;
        $product->save();
        // Log::info('saving product');
        $product->attachTags($tags); //create or find and attach tags
        $product->addFeatures($names, $descriptions); //add Features in database realted this product
        // Log::info('attacjing tags and features');

        $basePath ="/adminCMS/uploads/products/$product->id";
        $basePathPublic   = public_path($basePath);
        $basePathAsset    = asset($basePath);


        $thumbnailFile  = $request->file('thumbnail');
        $thumbnailName  = $product->storeFile($thumbnailFile, $basePath);
        $product->product_image = $basePathAsset.'/'.$thumbnailName;
        // Log::info('Thumbnails stored');

        if($request->hasFile('video')){
            $videoFile      = $request->file('video');
            $videoName      = $product->storeFile($videoFile,$basePath.'/video');
            $product->video = $basePathAsset.'/video'.'/'.$videoName;
        }
        // Log::info('Videos stored');
        $product->save();

        $productImagesFiles = $request->file('product_images');

        $destinationPath      = $basePathPublic.'/productImages';
        $destinationPathAsset = $basePathAsset.'/productImages';

        if(!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
            chmod($destinationPath, 0777);
        }

        foreach($productImagesFiles as $imageFile) {
            if($imageFile != "") {
                $filename = $imageFile->getClientOriginalName();
                $imageFile->move($destinationPath, $filename);
                // Log::info('Product images stored');
                $product->thumbnails()->create([
                    'image'=> $destinationPathAsset.'/'.$filename,
                ]);
            }
        }

        $openFileThumb = $request->file('openImage');
        $filenameOpen = $openFileThumb->getClientOriginalName();
        $openFileThumb->move($destinationPath, $filenameOpen);
        // Log::info('Opened image stored');
        $closeFileThumb = $request->file('closeImage');
        $filenameClose = $closeFileThumb->getClientOriginalName();
        $closeFileThumb->move($destinationPath, $filenameClose);
        // Log::info('closed image stored');
        $product->thumbnails()->create([
            'image'=> $destinationPathAsset.'/'.$filenameOpen,
            'isOpen' =>1
        ]);

        $product->thumbnails()->create([
            'image'=> $destinationPathAsset.'/'.$filenameClose,
            'isOpen' =>0
        ]);


        $svgpanels = $request->file('svgpanels');


        $destinationPath = $basePathPublic.'/svgpanels';
        $destinationPathAsset = $basePathAsset.'/svgpanels';

        if(!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
            chmod($destinationPath, 0777);
        }
        $i = 0;
        foreach($svgpanels as $svgpanel) {

            if($svgpanel != "") {
                $filename = $svgpanel->getClientOriginalName();
                $svgpanel->move($destinationPath, $filename);

                $product->panels()->create([
                    'image'=> $destinationPathAsset.'/'.$filename,
                    'name'=> $panelsNames[$i],
                ]);
                // Log::info('Panels moeved stored');
            }
            $i++;
        }
        if ($request->hasFile('panelTarget')){
            $panelTarget = $request->file('panelTarget');
            $filenametarget = $panelTarget->getClientOriginalName();
            $panelTarget->move($destinationPath, $filenametarget);
            // Log::info('Target stored');
            $product->panels()->create([
                'image'=> $destinationPathAsset.'/'.$filenametarget,
                'name'=> $request->input('panelNameT'),
                'isTarget'=>1
            ]);
        }

        if ($request->hasFile('illustration_images')){
            $illustrations = $request->file('illustration_images');
            $destinationPath = $basePathPublic.'/illustrations';
            $destinationPathAsset = $basePathAsset.'/illustrations';
            if(!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
                chmod($destinationPath, 0777);
            }
            foreach($illustrations as $illust) {
                 if($illust != "") {
                  // Log::info('Illustrations stored');
                    $filename = $illust->getClientOriginalName();
                    $illust->move($destinationPath, $filename);

                    $product->illustrations()->create([
                        'image'=> $destinationPathAsset.'/'.$filename
                    ]);
                }
            }
        }



        $request->session()->flash('status', true);
        $request->session()->flash('mess', "Product added successfully !!");

        $products = Product::all();

        return view('adminCMS/addproducts')->with(['products' => $products, 'success' => 'Uploaded successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateproduct(Request $request)
    {
//        dd($request->all());
//        $pricingJson = [];
        $from    = $request->input('from');
        $to      = $request->input('to');
        $price   = $request->input('price');
        $names   = $request->input('names');
        $panelsNames   = $request->input('panelsNames');
        $minePanelsNames   = $request->input('minePanelsNames');
        $minepaneids   = $request->input('minepaneids');
        $descriptions   = $request->input('descriptions');
        $featuresIds   = $request->input('features');
        $tags    = json_decode($request->input('tags'),true);
        $i=0;
        $product                  = Product::find($request->input('product_id'));
        $product->tags()->detach();
        $product->product_name    = $request->input('productname');
        $product->weight          = $request->input('weight');
        $product->pricePerWeight  = $request->input('pricePerWeight');
        $product->pricingJson     = Product::pricingJson($from, $to, $price);
        $product->save();

        $product->attachTags($tags); //create or find and attach tags
        $product->addFeatures($names, $descriptions,$featuresIds); //add Features in database realted this product
        $basePath ="/adminCMS/uploads/products/$product->id";
        $basePathPublic   = public_path($basePath);
        $basePathAsset    = asset($basePath);


        foreach ($minepaneids as $paneid){
            Panel::where('id',$paneid)->update(['name'=>$minePanelsNames[$i]]);
            $i++;
        }

        /*array Id element to delete */
        if(!empty($request->input('thumsdel'))){
            $thumbsToDelete = json_decode($request->input('thumsdel'));
            foreach ($thumbsToDelete as $item) {
                $thumb = Thumbnail::find($item);
                unlink(Product::getPublicPath($thumb->image,'adminCMS'));
                $thumb->delete();
            }
        }

        /*array Id element to delete */
        if(!empty($request->input('illusdel'))){
            $illusToDelete = json_decode($request->input('illusdel'));
            foreach ($illusToDelete as $item) {
                $illus = Illustration::find($item);
                unlink(Product::getPublicPath($illus->image,'adminCMS'));
                $illus->delete();
            }
        }

        if(!empty($request->input('panedel'))){
            $illusToDelete = json_decode($request->input('panedel'));
            foreach ($illusToDelete as $item) {
                $panel = Panel::find($item);
                unlink(Product::getPublicPath($panel->image,'adminCMS'));
                $panel->delete();
            }
        }

        if($request->hasFile('thumbnail')){
            unlink(Product::getPublicPath($product->product_image, 'adminCMS'));
            $thumbnailFile  = $request->file('thumbnail');
            $thumbnailName  = $product->storeFile($thumbnailFile, $basePath);
            $product->product_image = $basePathAsset.'/'.$thumbnailName;
            $product->save();
        }
        if($request->hasFile('openImage')){
            $destinationPathAsset = $basePathAsset.'/productImages';
            unlink(Product::getPublicPath($product->thumbnails()->where('isOpen',1)->first()->image, 'adminCMS'));
            $openImage  = $request->file('openImage');
            $thumbnailName  = $product->storeFile($openImage, $basePath.'/productImages');
            $product->thumbnails()->where('isOpen',1)->update([
                'image'=>$destinationPathAsset.'/'.$thumbnailName
            ]);
        }
        if($request->hasFile('closeImage')){
            $destinationPathAsset = $basePathAsset.'/productImages';
            unlink(Product::getPublicPath($product->thumbnails()->where('isOpen',0)->first()->image, 'adminCMS'));
            $closeImage  = $request->file('closeImage');
            $thumbnailName  = $product->storeFile($closeImage, $basePath.'/productImages');
            $product->thumbnails()->where('isOpen',0)->update([
                'image'=>$destinationPathAsset.'/'.$thumbnailName
            ]);
        }
        if($request->hasFile('video')){
            $destinationPathAsset = $basePathAsset.'/video';
            unlink(Product::getPublicPath($product->video, 'adminCMS'));
            $videoFile  = $request->file('video');
            $videoName= $product->storeFile($videoFile, $basePath.'/video');
            $product->video = $destinationPathAsset.'/'.$videoName;
            $product->save();
        }
        if($request->hasFile('product_images')){
            $productImagesFiles = Input::file('product_images');

            $destinationPath = $basePathPublic.'/productImages/';
            $destinationPathAsset = $basePathAsset.'/productImages';

            if(!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
                chmod($destinationPath, 0777);
            }

            foreach($productImagesFiles as $imageFile) {
                if($imageFile != "") {
                    $filename = $imageFile->getClientOriginalName();
                    $imageFile->move($destinationPath, $filename);

                    $product->thumbnails()->create([
                        'image'=> $destinationPathAsset.'/'.$filename,
                    ]);
                }
            }
        }

        if($request->hasFile('illustration_images')){
            $illustrations = Input::file('illustration_images');
            $destinationPath = $basePathPublic.'/illustrations/';
            $destinationPathAsset = $basePathAsset.'/illustrations';

            if(!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
                chmod($destinationPath, 0777);
            }
            foreach($illustrations as $illust) {
                if($illust != "") {
                    $filename = $illust->getClientOriginalName();
                    $illust->move($destinationPath, $filename);

                    $product->illustrations()->create([
                        'image'=> $destinationPathAsset.'/'.$filename
                    ]);
                }
            }
        }
        if($request->hasFile('svgpanels')) {
            $svgpanels = Input::file('svgpanels');


            $destinationPath = $basePathPublic.'/svgpanels/';
            $destinationPathAsset = $basePathAsset.'/svgpanels';

            if(!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
                chmod($destinationPath, 0777);
            }
            $i = 0;
            foreach($svgpanels as $svgpanel) {

                if($svgpanel != "") {
                    $filename = $svgpanel->getClientOriginalName();
                    $svgpanel->move($destinationPath, $filename);

                    $product->panels()->create([
                        'image'=> $destinationPathAsset.'/'.$filename,
                        'name'=> $panelsNames[$i],
                    ]);
                }
                $i++;
            }
        }
        $request->session()->flash('status', true);
        $request->session()->flash('mess', "Product was updated successfully !!");


        return redirect()->back();

//        $products = Product::all();
//
//        return view('adminCMS/products')->with(['products' => $products, 'success' => 'Uploaded successfully']);
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

        $product = Product::find($id);

        $product->keywords = $request->keywords;

        $product->save();

        return Response::json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $id)
    {
        Panel::where('product_id', '=', $id)->delete();

        $product = Product::destroy($id);

        //recursiveRemove(base_path() . '/public/adminCMS/uploads/products/'.$id);

        return Response::json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
//        $panels = Panel::where('product_id', '=', $id)->get();
//        $illustrations = Illustration::where('product_id', '=', $id)->get();
        return view('adminCMS/editproducts')->with(['product' => $product, /*'panels' => $panels, 'illustrations' => $illustrations*/]);
    }

    public function search($search_input)
    {
        $products = Product::where('product_image', 'LIKE', '%'.$search_input.'%')->get();
        return View::make('adminCMS/products')->with(['products' => $products]);
    }

    /**
     * Search for the specified resource.
     *
     * @param  string  $search_input
     * @return \View
     */
    public function searchproducts($search_input)
    {
        $products = Product::where('keywords', 'LIKE', '%'.$search_input.'%')->get();
        return View::make('getProducts')->with(['products' => $products]);
    }

    private function recursiveRemove($dir) {
        $structure = glob(rtrim($dir, "/").'/*');
        if (is_array($structure)) {
            foreach($structure as $file) {
                if (is_dir($file)) recursiveRemove($file);
                elseif (is_file($file)) unlink($file);
            }
        }
        rmdir($dir);
    }

    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir")
                        rrmdir($dir."/".$object);
                    else unlink   ($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function removeFeature(Request $request)
    {
        $feature = Features::find($request->input('featureId'));

        $feature->delete();

        return response()->json([
            'status'=>true,
            'mess'=>'feature deleted successfully'
        ]);

    }
}
