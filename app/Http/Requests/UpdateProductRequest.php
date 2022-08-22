<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CustomFormRequest;


class UpdateProductRequest extends CustomFormRequest
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
            'name' => 'max:100|nullable',
            'price' => 'integer|nullable',
            'image' => 'max:200|nullable',
            'description' => 'max:200|nullable',
            'types' => 'nullable'
        ];
    }
}
