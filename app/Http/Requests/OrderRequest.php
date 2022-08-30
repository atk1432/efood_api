<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CustomFormRequest;


class OrderRequest extends CustomFormRequest
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
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'phone' => 'required|integer',
            'address' => 'required|max:100',
            'info_for_shipper' => 'nullable|max:100',
            'products' => 'required'
        ];
    }
}
