<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanvasImages extends Model
{
    protected $table ='canvas_images';
    protected $fillable = ['path','layout_id'];

    public  function layout()
    {
        return $this->belongsTo(Layout::class);
    }

}
