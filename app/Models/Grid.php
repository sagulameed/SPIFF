<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    use Purchasable;

	protected $fillable = ['grid_name', 'single','multiple','right','isFree','price', 'keywords'];
    protected $hidden = ['created_at','updated_at'];

	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
