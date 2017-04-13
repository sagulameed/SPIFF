<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name','description','status'];
	protected $hidden = ['pivot','created_at','updated_at'];

    public function videos()
    {
    	return $this->belongsToMany(Video::class);
    }
}
