<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\CustomFormRequest;


class StoreProductRequest extends CustomFormRequest
{  
    protected $redirect = '/api/products';

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
            'name' => 'required|max:100',
            'price' => 'required|integer',
            'image' => 'required|max:200',
            'description' => 'nullable|max:200',
        ];
    }

    public function messages() 
    {
        return [

        ];
    }
}
