<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationPost extends FormRequest
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
     * Get tailored error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() 
    {
        return [
            'name.required' => 'A medication name is required',
            'withdrawal_period' => 'Format must match  mm/dd/yyyy', 
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'medical_id' => 'required|integer',
            'name' => 'required|string',
            'withdrawal_period' => 'nullable|date'
        ];
    }
}
