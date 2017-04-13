<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{	
	protected $fillable = ['product_name','user_id','product_image','video'];

	public function user()
    {
	    return $this->belongsTo(User::class);
    }

    /*public function layouts()
    {
        return $this->hasMany(Layout::class);
    }*/

    public function adminDesigns()
    {
        return $this->hasMany(AdminDesign::class);
    }
    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function illustrations()
    {
        return $this->hasMany(Illustration::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function features()
    {
        return $this->hasMany(Features::class);
    }
    public function panels()
    {
	    return $this->hasMany(Panel::class);
    }

    public function thumbnails()
    {
        return $this->hasMany(Thumbnail::class);
    }

    public static function pricingJson($from, $to, $price)
    {
        $pricingJson = [];
        for($i=0 ; $i < count($from); $i++){
            if (!empty($from[$i]) && !empty($to[$i]) && !empty($price[$i])){
                array_push($pricingJson,[
                    'from'=> $from[$i],
                    'to'=>$to[$i],
                    'price' =>$price[$i]
                ]);
            }

        }
        return json_encode($pricingJson);
    }

    public function attachTags($tags)
    {
        foreach ($tags as $key => $value) {
            $tagName =  $tags[$key]['name'];
            $tag = Tag::firstOrCreate(['name'=>$tagName]);
            $this->tags()->attach($tag->id);
        }
    }

    public function addFeatures($names, $descriptions ,$featuresIds = null)
    {
        for($i=0; $i < count($names); $i++){
            if (!empty($names[$i]) && !empty($descriptions[$i])){

                if (empty($featuresIds[$i])){
                    $this->features()->create([
                        'name'=> $names[$i],
                        'description'=> $descriptions[$i]
                    ]);
                }else{
                    $feature = Features::find($featuresIds[$i]);
                    $feature->name          =  $names[$i] ;
                    $feature->description   =   $descriptions[$i] ;
                    $feature->save();
                }

            }
        }
    }


    /**
     * Get the price interval according to the num Pieces
     * @param $numPieces
     * @return int
     */
    private function searchIntervalPrice($numPieces)
    {
        $result = 0;
        $rankpieces = json_decode($this->pricingJson);
        //if num pieces is bigger thank the max rank take the last price
        if ($numPieces > $rankpieces[count($rankpieces) -1]->price){
            $result = $rankpieces[count($rankpieces) -1]->price;
        }
        //search interval
        foreach ($rankpieces as $rank) {
            if  ($numPieces >= $rank->from && $numPieces <= $rank->to){
                    $result = $rank->price;
            }
        }

        return $result;
    }

    public function calcPricePieces($numPieces)
    {
        return $numPieces * $this->searchIntervalPrice($numPieces);
    }

    public function calcPriceDelivery($numPieces)
    {
        return $numPieces * number_format($this->pricePerWeight,2) * number_format($this->weight, 2);
    }

    public function storeFile($file , $basePath){

        $basePathPublic   = public_path($basePath);

        if(!file_exists($basePathPublic)) {
            mkdir($basePathPublic, 0777, true);
            chmod($basePathPublic, 0777);
        }

        $filename = $file->getClientOriginalName();
        $file->move($basePathPublic, $filename);

        return $filename;
    }

    public static function getPublicPath($string , $coincidence){
        $whatIWant = substr($string, strpos($string, $coincidence));
        return public_path($whatIWant);
    }


}
