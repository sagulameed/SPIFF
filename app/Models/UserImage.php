<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model {
	protected $fillable = ['image_name', 'user_id'];
}
