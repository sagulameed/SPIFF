<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderAndPayRequest;
use App\Mail\OrderPaid;
use App\Models\Design;
use App\Models\Helpers;
use App\Models\OrderElement;
use App\Models\PurchaseElement;
use App\Models\ShippingAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\ApiConnection;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Stripe;

class OrdersController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth')->except('elementPurchased');
        $this->middleware('isUser')->except('elementPurchased');
        $this->middleware('isCustomer')->only('show');
        $this->middleware('isOwnerPaymentInfo')->only('store');
        $this->middleware('checkElementsLicenses')->only('store');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderAndPayRequest $request)
    {
        try{
          //  dd($request->all());
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $total          = 0;
            $totalDelivery  = 0;
            $totalPieces    = 0;
            $totalElements  = 0;
            $user           = Auth::user();
            $customer       = Customer::retrieve($user->stripe_id);
            $design         = Design::find($request->input('designId'));
            $numPieces      = $request->input('numPieces');
            $product        = $design->product;
            $elementsJson   = json_decode($request->input('elementsPurchased'));

            foreach ($elementsJson as $element) {

                $isPurchased    = PurchaseElement::isPurchased($element->elementId, $element->elementType);
                $isPurchasedBool    = ($isPurchased['isWaterMark'] == true || $isPurchased==false)? false:true;

                if ($isPurchasedBool){
                    continue;
                }
                if(!empty($element->license)){
                    $objElement     = OrderElement::findOriginalElement($element->elementId, $element->elementType);
                    $totalElements += number_format($objElement->{$element->license}, 2);
                }
            }

            $totalPieces    = $product->calcPricePieces($numPieces);
            $totalDelivery  = $product->calcPriceDelivery($numPieces);

            $total = $totalDelivery + $totalPieces + $totalElements;
//            dd($request->all(), $totalElements, $totalDelivery, $totalPieces,$total);
            /*Creating the order in our server*/
            $order = $design->order()->create([
                'total'             => $total,
                'totalElements'     => $totalElements,
                'totalPieces'       => $totalPieces,
                'totalDelivery'     => $totalDelivery,
                'numPieces'         => $numPieces,
                'user_id'           => Auth::user()->id,
                'json_info'         => 'json info',
                'ordered_at'          => $request->input('ordered_at')
            ]);
            //dd($totalPieces,$totalDelivery,$totalElements,$total,number_format((float)$total*100., 0, '.', ''));
            /*
            * If Payment passes and is successfully create
            * the Order and the elements
            */

            $shipping = ShippingAddress::find($request->input('shipping'));

            $charge = Charge::create([
                'amount' => number_format((float)$total*100., 0, '.', ''),//(int)($total*100),
                'currency' => 'usd',
                'description' => 'Order and buy',
                'customer' => $customer->id,
                'source' => $request->input('card'),
                'metadata' => [
                    'order_id'      => $order->id,
                    'totalPieces'   => $totalPieces,
                    'totalDelivery' => $totalDelivery,
                    'totalElements' => $totalElements,
                    'numPieces'     => $numPieces,
                    'product_id'    => $product->id,
                    'shipping'      => json_encode($shipping->toArray())
                ]
            ]);

            $order->json_info = json_encode($charge);
            $order->save();
            /*
             * adding elements in order and for the  Users purchases
             * */
            foreach ($elementsJson as $elementJ){
                if(!empty($elementJ->license)){
                    $objElement     = OrderElement::findOriginalElement($elementJ->elementId, $elementJ->elementType);
                    /*Elements ordered associated to an order*/
                    $order->elements()->create([
                        'license'       => $elementJ->license,
                        'type'          => $elementJ->elementType,
                        'price'         => $objElement->{$elementJ->license},
                        'element_id'    => $elementJ->elementId
                    ]);
                    /*List of element purchased */
                    $user->elementsPurchased()->create([
                        'license'       => $elementJ->license,
                        'type'          => $elementJ->elementType,
                        'price'         => $objElement->{$elementJ->license},
                        'element_id'    => $elementJ->elementId,
                        'design_id'     => ($elementJ->license === 'single')?$design->id:''
                    ]);
                }
            }

            $request->session()->flash('status', true);
            $request->session()->flash('mess', 'Thanks for your purchased. The payment was for $ '.$total.' USD');
            $request->session()->flash('isPaymentSuccess', true);

            Mail::to($user->email)->send(new OrderPaid($order, $design,$numPieces));
//            dd($design->toArray(),$product->toArray(), 'pieces='.$numPieces , $elementsJson,'totao of pieces:'. $totalPieces,'delivery total:'.$totalDelivery,'total elements:'. $totalElements, $total);

        } catch (Card $e){
            $eJson = $e->getJsonBody();
            $request->session()->flash('status', false);
            $request->session()->flash('mess', $eJson['error']['message']);
            Log::info("{$e->getFile()},  {$e->getLine()},{$eJson['error']['message']}");
            if($order){
                $order->delete();
            }
        }
        catch (ApiConnection $e) {
            // Network problem, perhaps try again.
            $eJson = $e->getJsonBody();
            $request->session()->flash('status', false);
            $request->session()->flash('mess', $eJson['error']['message']);
            Log::info($eJson['error']['message']);
            if($order){
                $order->delete();
            }

        } catch (InvalidRequest $e) {
            // You screwed up in your programming. Shouldn't happen!
            $eJson = $e->getJsonBody();
            $request->session()->flash('status', false);
            $request->session()->flash('mess', $eJson['error']['message']);
            Log::info($eJson['error']['message']);
            if($order){
                $order->delete();
            }
        }
        catch (\Exception $e){
            $request->session()->flash('status', false);
            $request->session()->flash('mess', 'Service not available try later.');
            Log::info($e->getMessage());
            if($order){
                $order->delete();
            }
        } finally{
            return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $elements = collect();
        $user = Auth::user();
        $design     = Design::find($id);
        $product    = $design->product;

        foreach ($design->layouts as $lay) {
            //getting path and content
            $canvasJson = json_decode(file_get_contents(Helpers::getPublicPath($lay->canvas_json, 'uploads')));
//            dd($canvasJson[1]->objects);

            foreach ($canvasJson[1]->objects as $object) {
                if (empty($object->elementId))continue;
                //checking if the element exist in previous collection
                $exists = $elements->contains(function ($value , $key) use ($object){
                    return $value['elementId'] == $object->elementId &&  $value['elementType'] == $object->elementType;
                });

                if (!$exists){ //pushing in collection if it does not exist
                    $modelName  = ucfirst($object->elementType);
                    $model      = app("App\\Models\\$modelName");
                    $element    = $model::find($object->elementId);
//                    dd($element->isPurchased());
                    $elements->push([
                        'layId'         => $lay->id,
                        'elementId'     => $object->elementId,
                        'elementType'   => $object->elementType,
                        'src'           => (!isset($object->origfill))?$object->src:$object->origfill->fillsrc,
                        'single'        => $element->single,
                        'multiple'      => $element->multiple,
                        'right'         => $element->right,
                        'isFree'        => $element->isFree,
                        'price'         => 0,
                        'license'       => '',
                        'isPurchased'   => ($element->isPurchased()['isWaterMark'] == true || $element->isPurchased()==false)? false:true
                    ]);
                }

            }
        }

      //  dd($elements);

        Stripe::setApiKey(env('STRIPE_SECRET'));
        $shippings   = $user->shippingAddresses;
        $cards      = Customer::retrieve($user->stripe_id)->sources->all(['object'=>'card'])->data;
        return view('orders.order',compact('design','product','elements','shippings','cards'));
    }


    public function elementPurchased(Request $request)
    {
        $elementId  = $request->input('elementId');
        $type       = $request->input('type');
        $hours = 0;

//        $element = PurchaseElement::where('element_id',$elementId)->where('type',$type)->where('user_id',Auth::user()->id)->first();
        $element = PurchaseElement::where('element_id',$elementId)->where('type',$type)->where('user_id',2)->first();

        //If element not found or element does not belong to the user in session
        if(!$element){
            return response()->json(['status'=>false,'mess'=>'Element not found'],404);
        }

        if($element->license == 'single'){
            $createdAt = Carbon::parse($element->created_at);
            $hours = Carbon::now()->diffInHours($createdAt);
            return response()->json([
                'status'=>true,
                'element'=>$element,
                'isWaterMark'=>($hours >= 24)?true:false,
                'forDesign' => $element->design_id
            ],200);
        }

        return response()->json([
            'status'=>true,
            'element'=>$element,
            'isWaterMark'=>($hours >= 24)?true:false,
        ],200);



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
