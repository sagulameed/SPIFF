<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = ['name','user_id','product_id'];

    public function share()
    {
        return $this->hasOne(Share::class);
    }

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function layouts()
    {
        return $this->hasMany(Layout::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public static function getPublicPath($string , $coincidence){
        $whatIWant = substr($string, strpos($string, $coincidence));
        return public_path($whatIWant);
    }
}
