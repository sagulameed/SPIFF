<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Target extends Model
{
    protected  $fillable = ['rank','targetId'];
    protected $dates = ['created_at','updated_at'];

    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    public function design()
    {
        return $this->hasOne(Design::class);
    }
}
