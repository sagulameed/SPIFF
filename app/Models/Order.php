<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['total','totalElements','totalDelivery','totalPieces','numPieces','json_info','ordered_at','user_id','design_id'];

    public function buyer()
    {
        return $this->belongsTo(User::class);
    }

    public function elements()
    {
        return $this->hasMany(OrderElement::class);
    }

    public function design()
    {
        return $this->belongsTo(Design::class);
    }

}
