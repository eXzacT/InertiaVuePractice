<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateListingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'beds' => 'required|integer|min:0|max:20',
        'baths' => 'required|integer|min:0|max:20',
        'area' => 'required|integer|min:15|max:1500',
        'city' => 'required',
        'code' => 'required',
        'street' => 'required',
        'street_nr' => 'required|integer|min:1|max:200',
        'price' => 'required|integer|min:1|max:20000000',
        ];
    }
}
