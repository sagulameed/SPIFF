<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    protected $fillable = ['image','product_id','name','isTarget'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
