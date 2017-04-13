<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    protected $fillable = ['name','description','product_id'];


    public function products()
    {
        $this->belongsTo(Product::class);
    }
}
