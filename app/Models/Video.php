<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Video extends Model
{
    protected $fillable = ['title','subtitle','description','thumbnail','video','duration','numViews','user_id','rate'];
	protected $hidden = ['pivot','created_at','updated_at','description','status'];

    public function categories()
    {
    	return $this->belongsToMany(Category::class);
    }
    
    public function tags()
    {
    	return $this->belongsToMany(Tag::class);
    }

    public function users()
    {
        return $this->belongsToMany(Rate::class,'rate_video');
    }



    public function rate($rate)
    {
        $numVotes   = $this->numVotes;
        $rating     = $this->rate;
        $newRate = ($rating*$numVotes + intval($rate)) /  ++$numVotes;
        $this->rate = $newRate;
        $this->numVotes += 1;
        $this->save();

        return $this->rate;
    }
}
