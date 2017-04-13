<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {
	
	protected $primaryKey = 'template_id';
	protected $fillable = ['template_name', 'canvas_thumbnail','canvas_json'];

}
