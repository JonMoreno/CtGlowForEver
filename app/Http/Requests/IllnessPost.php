<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IllnessPost extends FormRequest
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
     * {@inheritDoc}
     * @see \Illuminate\Foundation\Http\FormRequest::messages()
     */
    public function messages()
    {
        return [
            'name.required' => 'A product name is required',
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
            'name' => 'required|max:25',
        ];
    }
    
    
}
