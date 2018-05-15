<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseDiscountPost extends FormRequest
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
            'client_id' => 'required|numeric',
            'invoice_id' => 'required|numeric',
            'discount_id' => 'required|numeric',
            'discount_type' => 'required|string',
            'discount_value' => 'required|numeric',

            'service' => 'sometimes|required|string',
            'service_id' => 'sometimes|required|numeric',
            'service_original_price' => 'sometimes|required|numeric',
            
        ];
    }
}
