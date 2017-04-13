<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderElement extends Model
{
    protected $table = 'order_elements';
    protected $fillable = ['license','type','price','element_id','order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Find element , illustratiion, picture, background etc
     * @param $elementId
     * @param $modelName
     * @return mixed
     */
    public static function findOriginalElement($elementId , $modelName)
    {
        $modelName      = ucfirst($modelName);
        $model          = app("App\\Models\\$modelName");

        return $model::find($elementId);
    }


    public function originalElement()
    {
        $modelName      = ucfirst($this->type);
        $model          = app("App\\Models\\$modelName");

        return $model::find($this->element_id);
    }

}
