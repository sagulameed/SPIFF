<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = Auth::user();

        if(is_null($user->stripe_id)){
            $request->session()->flash('status', false);
            $request->session()->flash('mess', "Please set a Credit Card and Shipping Address");
            return redirect('me/paymentConf');
        }

        return $next($request);
    }
}
