<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use Purchasable;

    protected $fillable = ['line_name','price', 'single','multiple','right','isFree','keywords'];
    protected $hidden = ['created_at','updated_at'];

	public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
