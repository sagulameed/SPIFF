<?php

namespace App\Http\Middleware;

use App\Models\Design;
use App\Models\ShippingAddress;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;

class IsOwnerPaymentInfo
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

        try{
            if (empty($request->input('card')) || empty($request->input('shipping'))){
                $request->session()->flash('status', false);
                $request->session()->flash('mess', "Your payment info is incomplete");
                return redirect()->back();
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $user   = Auth::user();
            $design = Design::find($request->input('designId'));

            if(!$design || $design->user_id !== $user->id){
                $request->session()->flash('status', false);
                $request->session()->flash('mess', "It seems this design does not belong to you.");
                return redirect()->back();
            }

            $customer   = Customer::retrieve($user->stripe_id);
            $card       = $customer->sources->retrieve($request->input('card'));

            if(!$card){
                $request->session()->flash('status', false);
                $request->session()->flash('mess', "It seems this is not your card.");
                return redirect()->back();
            }

            $shipping = ShippingAddress::find($request->input('shipping'));

            if (!$shipping || $shipping->user_id !== $user->id){
                $request->session()->flash('status', false);
                $request->session()->flash('mess', "It seems this shipping address is not yours.");
                return redirect()->back();
            }


            return $next($request);

        } catch (ApiConnection $e) {
            // Network problem, perhaps try again.
            $eJson = $e->getJsonBody();
            $request->session()->flash('status', false);
            $request->session()->flash('mess', $eJson['error']['message']);
            Log::info($eJson['error']['message']);
            return redirect()->back();

        } catch (InvalidRequest $e) {
            // You screwed up in your programming. Shouldn't happen!
            $eJson = $e->getJsonBody();
            $request->session()->flash('status', false);
            $request->session()->flash('mess', $eJson['error']['message']);
            Log::info($eJson['error']['message']);
            return redirect()->back();

        }
        catch (\Exception $e){
            $request->session()->flash('status', false);
            $request->session()->flash('mess', 'Service not available try later. We did not order and make any payment');
            Log::info($e->getMessage());
            return redirect()->back();
        }

    }
}
