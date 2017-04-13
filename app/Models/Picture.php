<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {

    use Purchasable;

	protected $fillable = ['picture_name', 'single','multiple','right','isFree', 'keywords'];
    protected $hidden = ['created_at','updated_at'];

	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
