<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLayout extends Model
{
    protected $primaryKey = 'id';
	protected $fillable = ['canvas_thumbnail','canvas_image','canvas_json','adminDesign_id','isTarget','name'];


    public function adminDesign()
    {
        return $this->belongsTo(AdminDesign::class);
    }
}
