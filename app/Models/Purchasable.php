<?php
/**
 * Created by PhpStorm.
 * User: inmersys
 * Date: 3/30/17
 * Time: 10:24 AM
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait Purchasable
{
    private function getClassName() {
        $path = explode('\\', __CLASS__);
        return $path[count($path)-1];
    }

    public function isPurchased()
    {
        $hours = 0;
        $class = $this->getClassName();
        $purchasedElement = PurchaseElement::where('element_id', $this->id)->where('type', lcfirst($class))->where('user_id', Auth::user()->id)->first();
//        dd($purchasedElement->toArray());
        //If element not found or element does not belong to the user in session
        if(!$purchasedElement){
            return false;
        }
        //if is single licen check 24 hours have been finished
        if($purchasedElement->license == 'single'){
            $createdAt = Carbon::parse($purchasedElement->created_at);
            $hours = Carbon::now()->diffInHours($createdAt);
            $purchasedElement->delete();
            return [
                'isWaterMark'=>($hours>=24)?true:false,
                'design'=> $purchasedElement->design_id
            ];

        }

       return  [
        'isWaterMark'=>($hours>=24)?true:false,
       ];
    }
}