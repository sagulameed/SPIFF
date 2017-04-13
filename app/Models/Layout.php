<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model {
	
	protected $primaryKey = 'id';
	protected $fillable = ['canvas_thumbnail','canvas_image','canvas_json','design_id','isTarget','name'];


    public function design()
    {
        return $this->belongsTo(Design::class);
    }

}
