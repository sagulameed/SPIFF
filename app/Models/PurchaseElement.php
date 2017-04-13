<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchaseElement extends Model
{
    protected $table = 'purchase_elements';
    protected $fillable = ['license','price','type','element_id','user_id','design_id'];
    protected $hidden = ['updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function findOriginalElement($elementId , $modelName)
    {
        $modelName      = ucfirst($modelName);
        $model          = app("App\\Models\\$modelName");

        return $model::find($elementId);
    }

    /**
     * Check if Purschased elemnt exists for user in session
     * @param $elementId
     * @param $elementType
     * @return array|bool
     */
    public static function isPurchased($elementId, $elementType)
    {
        $hours = 0;
        $purchasedElement = PurchaseElement::where('element_id', $elementId)->where('type', $elementType)->where('user_id', Auth::user()->id)->first();

        //If element not found or element does not belong to the user in session
        if(!$purchasedElement){
            return false;
        }
        //if is single licen check 24 hours have been finished
        if($purchasedElement->license == 'single'){
            $createdAt = Carbon::parse($purchasedElement->created_at);
            $hours = Carbon::now()->diffInHours($createdAt);
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
