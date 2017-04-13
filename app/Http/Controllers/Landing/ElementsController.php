<?php

namespace App\Http\Controllers\Landing;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ElementsController extends Controller
{


    /**
     * @description return elements with the tags in the string
     * @param Request $request
     * @return json with elements
     * @internal param $criteria
     */
    public function searchElements(Request $request)
    {

        $elementsResult = collect();
        $lines          = collect();
        $pictures       = collect();
        $frames         = collect();
        $grids          = collect();
        $backgrounds    = collect();
        $elements =['lines','pictures','frames','grids','backgrounds'];


        $criteria = $request->input('criteria');

        $tagsArr = preg_split( "/(,|\s+)/", $criteria ); //making array of rtring with comas and spaces
        foreach ($tagsArr as $tagName) {
            $tag = Tag::where('name',$tagName)->first();
            if($tag){
                Log::info($tagName);
                Log::info("-----------");
                foreach ($elements as $element) {
                    if(!empty($tag->$element)){
                        Log::info($element);
                        ${$element} = ${$element}->merge($tag->$element->toArray());
                    }
                }
                Log::info("**************");
            }
        }
        foreach ($elements as $element) {
            $elementsResult->put($element,${$element});
        }

        return response()->json($elementsResult);


    }


}
