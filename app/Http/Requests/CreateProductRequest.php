<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'productname'=> 'required',
            'names' => 'required',
            'tags' => 'required|json',
            'from' => 'required',
            'price' => 'required',
            'weight' => 'required|numeric',
            'pricePerWeight'=>'required|numeric',
            'panelsNames'=> 'required_with:svgpanels',
            'thumbnail' =>'required',
            'openImage' =>'required',
            'closeImage' =>'required',
            'product_images'=>'required',
            'panelTarget' =>'image',
            'panelNameT' => 'required_with:panelTarget'

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function messages()
    {
        return [
            'productname.required' => 'The name of the Product is required',
            'names.required'  => 'Features are required',
            'price.required' => 'Product price is required',
            'weight.numeric' => 'Product price must be numeric',
            'pricePerWeight.numeric' => 'Product price must be numeric',
            'weight'=>'Product weight is required',
            'pricePerWeight.required'=>'Price per weight is required',
            'panelsNames.required'=>'Panels name are required',
            'thumbnail.required'=>'Product thumbnail is required',
            'openImage.required'=>'Image of the opened Product is required',
            'closeImage.required'=>'Image of the closed Product is required',
            'panelTarget.image'=>'Panel target must be an image',
            'panelNameT.required_with'=>'Target Panel name is required',
            'tags.required' => 'Product tags are required',
            'tags.json' => 'Product tags json is invalid',
        ];
    }
}
