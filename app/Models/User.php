<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, HasApiTokens, Notifiable, Billable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 'password','role','name','thumbnail','firstName','secondName','isDeleted','stripe_id','card_brand','card_last_four'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token','role','created_at','updated_at','id'];

	public function rates()
    {
        return $this->belongsToMany(Video::class,'rate_video')->withTimeStamps();;
    }

    public function commentsShare()
    {
        return $this->belongsToMany(Share::class,'share_comment')->withPivot('user')->withTimeStamps();;
    }
    public function likesShare()
    {
        return $this->belongsToMany(Share::class,'share_like')->withTimeStamps();;
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function isShareLiked($shareId)
    {
        return $this->likesShare->contains($shareId);
    }


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function elementsPurchased()
    {
        return $this->hasMany(PurchaseElement::class);
    }


    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }


    public function isAdmin(){
	    return $this->role == 'admin';
    }
    public function isUser(){
        return $this->role == 'user';
    }

}