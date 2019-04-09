<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagazinRequest extends FormRequest
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
            'name' =>'required|min:1|max:32',
            'autor'   =>  'required|min:1|max:32',
            'number_per_year' =>  'required',
            'year' =>  'required',
            'number' =>  'required',
            'size' =>  'required',
            'price' =>  'required',
            'sub_price' =>  'required',
            'old_price' =>  'required',
            'img' =>  'nullable|image',
            'discont_global' => 'required',
        ];
    }
    /*
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name' => 'The :attribute value is required :input is not between 1:min - 32:max.',
            'author'  => 'The :attribute value :input is no more then 32:max.',
        ];
    }
}
