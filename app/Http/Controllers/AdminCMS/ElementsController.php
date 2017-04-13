<?php

namespace App\Http\Controllers\adminCMS;


use App\Http\Requests\EditElementRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Background;
use App\Models\Line;
use App\Models\Frame;
use App\Models\Picture;
use App\Models\Grid;
use Illuminate\Support\Facades\Log;

class ElementsController extends Controller
{

    /**
     * @param Request $request
     */
    public function elementDetails(EditElementRequest $request)
    {
        try{

//            dd($request->all());
            $isFree             = filter_var($request->input('pricecheckbox'), FILTER_VALIDATE_BOOLEAN);
            $isSinglePrice      = filter_var($request->input('checkSinglePrice'), FILTER_VALIDATE_BOOLEAN);
            $isMultiplePrice    = filter_var($request->input('checkMultiplePrice'), FILTER_VALIDATE_BOOLEAN);
            $isRightPrice       = filter_var($request->input('checkRightPrice'), FILTER_VALIDATE_BOOLEAN);

            $idElement      = $request->input('idElement');
            $class          = $request->input('type');
            $tags           = json_decode($request->input('tags'),true);
            $className      = ucfirst($class);
            $model      = app("App\\Models\\$className");
            $element    = $model::find($idElement);
            $element->tags()->detach();

            if (!$isFree){
                if (!$isSinglePrice){
                    $priceSingle        = $request->input('singlePrice');
                    $element->single    = filter_var($priceSingle, FILTER_VALIDATE_FLOAT);
                }else{
                    $element->single = null;
                }
                if (!$isMultiplePrice){
                    $multiplePrice      = $request->input('multiplePrice');
                    $element->multiple  = filter_var($multiplePrice, FILTER_VALIDATE_FLOAT);
                }else{
                    $element->multiple = null;
                }
                if (!$isRightPrice){
                    $rightsPrice        = $request->input('rightPrice');
                    $element->right     = filter_var($rightsPrice, FILTER_VALIDATE_FLOAT);
                }else{
                    $element->right = null;
                }

                $element->isFree = false;
            }
            else{
                $element->isFree = true;
                $element->single = null;
                $element->multiple = null;
                $element->right = null;
            }


            $element->save();

            foreach ($tags as $key => $value) {
                $tagName =  $tags[$key]['name'];
                $tag = Tag::firstOrCreate(['name'=>$tagName]);
                Log::info('Attaching tag;'.$tagName);
                $element->tags()->attach($tag->id);
            }
            $request->session()->flash('status', true);
            $request->session()->flash('mess', "Element was updated successfully !!");

            return redirect()->back();
        } catch (\Exception $e){
            Log::info("Error updating element {$e->getMessage()},{$e->getLine()}");
            $request->session()->flash('status', true);
            $request->session()->flash('mess', "Service not Available try later please");
            return redirect()->back();
        }
    }
    public function searchElements(Request $request)
    {
//        dd($request->all());
        $elementsResult = collect();

        $element    = $request->input('elementType');
        $criteria   = $request->input('searchinput');

        $tagsArr = preg_split( "/(,|\s+)/", $criteria ); //making array of rtring with comas and spaces

        foreach ($tagsArr as $tagName) {
            $tag = Tag::where('name',$tagName)->first();
            if($tag){
//                Log::info('Tag found :'.$tagName);
                if(!empty($tag->$element)){
//                    Log::info($element);
                    foreach ($tag->$element as $item) { //element each one
//                        Log::info('Item found :'.$item->id);
                        $isContain = $elementsResult->contains(function($value, $key) use ($item){
//                            Log::info('Key found:'.$value->id.':'.$key);
                            return $value->id == $item->id;
                        });
                        if(!$isContain){
//                            Log::info('Picture pushed:'.$item->picture_name);
                            $elementsResult->push($item);
                        }
                    }
                }
//                Log::info("**************");
            }
        }

//        dd($elementsResult);
        return view("adminCMS/$element")->with([$element=>$elementsResult,'tags'=>$criteria]);


    }
}
