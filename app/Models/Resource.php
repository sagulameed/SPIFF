<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $dates = ['created_at','updated_at'];
    protected $fillable =['resource','type','targetId','thumbnail','orientation'];


    public function target()
    {
        return $this->belongsTo(Target::class);
    }



    public static function getPublicPath($string , $coincidence){
        $whatIWant = substr($string, strpos($string, $coincidence));
        return public_path($whatIWant);
    }
}
