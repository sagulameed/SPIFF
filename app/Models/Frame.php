<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    use Purchasable;

	protected $fillable = ['frame_name', 'single','multiple','right','isFree', 'keywords'];
    protected $hidden = ['created_at','updated_at'];


	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
