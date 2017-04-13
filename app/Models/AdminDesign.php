<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminDesign extends Model
{

    protected $table='admin_designs';
    protected $fillable =['name','isUploaded','product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function adminLayouts()
    {
        return $this->hasMany(AdminLayout::class);
    }
}
