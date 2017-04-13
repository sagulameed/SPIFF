<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use Purchasable;

	protected $fillable = ['background_name', 'single','multiple','right','isFree', 'keywords'];
    protected $hidden = ['created_at','updated_at'];

	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
