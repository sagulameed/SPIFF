<?php

namespace App\Http\Controllers\Landing;

use App\Models\Helpers;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isUser')->only(['profile','paymentConf']);
    }

    public function profile()
    {
        return view('users.profile');
    }

    public function profileConfig(Request $request)
    {
//        dd($request->all());
        $user = Auth::user();

        if($request->has('password')){
            $validator = Validator::make($request->all(), [
                'password' => 'min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $user->password = bcrypt($request->input('password'));

        }

        if($request->hasFile('thumbnail')){
            $thumbFile = $request->file('thumbnail');

            $path = 'uploads/thumbnails';

            @unlink(Helpers::getPublicPath($user->thumbnail,'uploads'));

            $thumbFile->move(public_path($path), $thumbFile->getClientOriginalName());

            $user->thumbnail = asset($path.'/'.$thumbFile->getClientOriginalName());
        }
        $user->firstName = $request->input('firstName');
        $user->secondName = $request->input('secondName');
        $user->save();

        $request->session()->flash('status', true);
        $request->session()->flash('mess', "Your Profile has been updated successfully");
        return redirect()->back();
    }

    public function paymentConf()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user       = Auth::user();
        $shippings  = $user->shippingAddresses;
        $cards      = (!is_null($user->stripe_id))? Customer::retrieve($user->stripe_id)->sources->all(['object'=>'card'])->data:[];

        return view('users.paymentConf',compact('shippings','cards'));
    }


    public function creditCard(Request $request)
    {
        try{

//            dd($request->all());

            $user = Auth::user();
            $stripeToken = $request->input('stripeToken');
            $card = json_decode($request->input('cardjson'));
            Stripe::setApiKey(env('STRIPE_SECRET'));

            if(empty($user->stripe_id)){
                $customer = Customer::create([
                    'email'=> $user->email,
                    'description' => 'User register with credit card first time',
                    'source' => $stripeToken,
                    'metadata' => ['userId'=>$user->id, 'email'=>$user->email]
                ]);

                $user->stripe_id        = $customer->id;
                $user->card_brand       = $card->brand;
                $user->card_last_four   = $card->last4;
                $user->save();


            } else{
                $customer = Customer::retrieve($user->stripe_id);
                //updating card
                if(!empty($request->input('idC'))){
                    $card = $customer->sources->retrieve($request->input('idC'));
                    $card->address_city     = $request->input('address_city');
                    $card->address_country  = $request->input('address_country');
                    $card->address_line1    = $request->input('address_line1');
                    $card->address_line2    = $request->input('address_line2');
                    $card->address_state    = $request->input('address_state');
                    $card->address_zip      = $request->input('address_zip');
                    $card->name             = $request->input('customerName');
                    $card->save();
                }
                else{
                    //creating new one with stripe token
                    $customer->sources->create(array("source" => $stripeToken));

                }
            }


            $request->session()->flash('status', true);
            $request->session()->flash('mess', 'Thanks, your Card has been added successfully');
            return redirect()->back();

        } catch (Card $e){
            Log::critical("{$e->getMessage()} : {$e->getStripeCode()} : {$e->getFile()}");
            $request->session()->flash('status', false);
            $request->session()->flash('mess', $e->getMessage());
            return redirect()->back();
        }
        catch (\Exception $e){
            Log::critical("{$e->getFile()} , {$e->getMessage()}, {$e->getLine()}");
            $request->session()->flash('status', false);
            $request->session()->flash('mess', 'Sorry this service is not available try later please');
            return redirect()->back();
        }

    }

    public function shippingAddress(Request $request)
    {
//        dd($request->all());
        $user = Auth::user();
        if(!empty($request->input('id'))){
            $shipping = ShippingAddress::where('id',$request->input('id'))
            ->update([
                'name' => ucfirst($request->input('name')),
                'businessName' => title_case($request->input('businessName')),
                'phone' => $request->input('phone'),
                'line1' => title_case($request->input('line1')),
                'line2' => title_case($request->input('line2')),
                'city' => title_case($request->input('city')),
                'country' => strtoupper($request->input('country')),
                'state' => strtoupper($request->input('state')),
                'postal_code' => $request->input('postal_code'),
            ]);
        }
        else{
            $user->shippingAddresses()->create([
                'name' => ucfirst($request->input('name')),
                'businessName' => title_case($request->input('businessName')),
                'phone' => $request->input('phone'),
                'line1' => title_case($request->input('line1')),
                'line2' => title_case($request->input('line2')),
                'city' => title_case($request->input('city')),
                'country' => strtoupper($request->input('country')),
                'state' => strtoupper($request->input('state')),
                'postal_code' => $request->input('postal_code'),
            ]);
        }

        $request->session()->flash('status', true);
        $request->session()->flash('mess', 'Thanks, your Shipping address has been added successfully');
        return redirect()->back();
    }
}
