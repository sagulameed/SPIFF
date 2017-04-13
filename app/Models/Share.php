<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $table='shares';
    protected $fillable = ['status','layout_id'];

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

    public function commentsUsers()
    {
        return $this->belongsToMany(User::class,'share_comment')->withTimeStamps()->withPivot('comment');
    }
    public function likesUsers()
    {
        return $this->belongsToMany(User::class,'share_like')->withTimeStamps();
    }

}
