<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['name','description','status'];
	protected $hidden = ['pivot','created_at','updated_at','description','status','id'];

    public function videos()
    {
    	return $this->belongsToMany(Video::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function lines()
    {
        return $this->belongsToMany(Line::class);
    }

    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }

    public function frames()
    {
        return $this->belongsToMany(Frame::class);
    }

    public function backgrounds()
    {
        return $this->belongsToMany(Background::class);
    }

    public function grids()
    {
        return $this->belongsToMany(Grid::class);
    }

    public function illustrations()
    {
        return $this->belongsToMany(Illustration::class);
    }
}
