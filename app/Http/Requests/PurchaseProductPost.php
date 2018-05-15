<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseProductPost extends FormRequest
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
            'sold_price' => 'required|numeric',
            'client_id' => 'required|numeric',
            'invoice_id' => 'required|numeric',
            'product_id' => 'required|numeric',
        ];
    }
}
