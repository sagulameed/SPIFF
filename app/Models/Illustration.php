<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Illustration extends Model
{
    use Purchasable;

	protected $fillable = ['name','price','image', 'keywords','product_id'];


	public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

}
