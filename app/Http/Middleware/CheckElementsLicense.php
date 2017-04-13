<?php

namespace App\Http\Middleware;

use App\Models\OrderElement;
use App\Models\PurchaseElement;
use Closure;
use Illuminate\Support\Facades\Log;

class CheckElementsLicense
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
        /*Validate elements of payment has license*/
        $elementsJson   = json_decode($request->input('elementsPurchased'));
        foreach ($elementsJson as $element) {

            $objElement         = OrderElement::findOriginalElement($element->elementId, $element->elementType);
            $isPurchased        = PurchaseElement::isPurchased($element->elementId, $element->elementType);

            $isPurchasedBool    = ($isPurchased['isWaterMark'] == true || $isPurchased==false)? false:true;

            Log::info($element->elementType.':'.$element->elementId. ':is Purchased'. $isPurchasedBool);

            if ($isPurchasedBool){
                continue;
            }

            if( $objElement->isFree == 0 && empty($element->license)){
                $request->session()->flash('status', false);
                $request->session()->flash('mess', "You have to choose a license for $element->elementType: $element->elementId");
                return redirect()->back();
            }

        }
        return $next($request);
    }
}
