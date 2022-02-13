<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => 'nullable|email',
            'mobile' => 'required|regex:/(07)[0-9]{9}/',
            'mobile2' => 'nullable|regex:/(07)[0-9]{9}/',
            'governorate' => 'required',
            'address' => 'required|min:5',
            'comment' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'first_name.required'        => 'يجب ادخال اسم الاول للمشتري',
            'first_name.max'          => 'يجب ان لا يتجاوز الاسم 20 حرف',

            'last_name.required'        => 'يجب ادخال اسم العائلة (الاب) للمشتري',
            'last_name.max'          => 'يجب ان لا يتجاوز الاسم 20 حرف',

            'email.email'         => 'البريد الالكتروني غير صالح',

            'mobile.required'       => 'يجب ادخال رقم الهاتف',
            'mobile.regex'        => 'رقم الهاتف يجب ان يتكون من 11 رقم ويبداء بـ 07',

            'mobile2.regex'        => 'رقم الهاتف يجب ان يتكون من 11 رقم ويبداء بـ 07',

            'governorate.required'       => 'يجب تحديد المحافظة',

            'address.required'       => 'يجب ادخال عنوان السكن واقرب نقطة دالة',
            'address.min'        => 'العنوان الذي ادخلته قصير',
        ];
    }
}
