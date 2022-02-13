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
            'phone' => 'required|regex:/(07)[0-9]{9}$/',
            'message' => 'required|min:5',
            'review' => 'nullable|url',
            'cover' => 'required|mimes:png,jpg,bmp,jpeg,gif,tiff,jfif|max:2000',
        ];
    }

    public function messages()
    {
        return [
            'pd_name.required'        => 'يجب ادخال اسم السلعة',
            'pd_name.unique'          => 'اسم السلعة موجود بالفعل',

            'categories_id.required'         => 'يجب تحديد القسم الرئيسي السلعة',
            'sub_cats_id.required'         => 'يجب تحديد القسم الفرعي السلعة',

            'pd_price.required'       => 'يجب ادخال سعر السلعة',
            'pd_price.numeric'        => 'يجب ادخال سعر السلعة كعدد فقط',

            'pd_stack.required'       => 'يجب ادخال عدد السلعة المتوفر',
            'pd_stack.numeric'        => 'يجب ادخال عدد السلعة كعدد فقط',

            'pd_description.required'   => 'يجب ادخال وصف للسلعة',
            'pd_description.min'        => 'يجب ادخال وصف للسلعة 10 حروف كحد ادنى',

            'phone.required'   => 'يجب ادخال رقم الهاتف',
            'phone.regex'        => 'رقم الهاتف يجب ان يتكون من 11 رقم ويبداء بـ 07',

            'message.required'   => 'يجب ادخال رسالة بدء المحادثة في الواتساب',
            'message.min'        => 'الرسالة قصيرة جدا',

            'review.url'        => 'رابط المراجعة غير صالح',

            'cover.required'        => 'يجب ادخال صورة الغلاف للسلعة',
            'cover.mimes'        => 'رجاء قم بأختيار صورة مناسبة',
            'cover.max'        => 'حجم الصورة المدخلة كبير : > 2 MB',
        ];
    }
}
