<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'pd_name' => 'required|unique:products',
            'categories_id' => 'required',
            'sub_cats_id' => 'required',
            'pd_price' => 'required|numeric',
            'pd_stack' => 'required|numeric',
            'pd_description' => 'required|min:10',
            'company' => 'nullable',
            'review' => 'nullable|url',
            'cover' => 'required|mimes:png,jpg,bmp,jpeg,gif,tiff,jfif|max:2000',
        ];
    }
}
