<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddVideoRequest extends Request
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
            'title'=>'required|string|max:70',
            'subtitle' =>'required|string|max:150',
            'description' =>'required|string',
            'video' =>'required',
            'tags' => 'required',
            'category' => 'required',
            'thumbnail' =>'required|image:jpeg,png,jpg'
        ];
    }
}
