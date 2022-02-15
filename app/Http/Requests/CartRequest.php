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
            'country' => 'required',
            'address' => 'required|min:5',
            'comment' => 'nullable',
        ];
    }
}
