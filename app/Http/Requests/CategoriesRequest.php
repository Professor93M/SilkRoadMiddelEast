<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'cat_name' => 'unique:categories|required|min:1',
            'img_url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cat_name.required'        => 'يجب ادخال اسم الصنف',
            'cat_name.unique' => 'اسم الصنف موجود فعلا',

            'img_url.required'    => 'يجب اختيار صورة للصنف',
        ];
    }
}
