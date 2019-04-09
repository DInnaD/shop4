<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            if($purchase->book->status == 1)
            {
                    $this->validate($request, [
                        'qty'   =>  'required'
                    ]);//not 0
            }
            else{
                    $this->validate($request, [
                        'qty_m'   =>  'required'
                    ]);//not 0
            }
        ];
    }
}
