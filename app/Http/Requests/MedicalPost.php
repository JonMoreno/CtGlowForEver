<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalPost extends FormRequest
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
            'dermatologist' => 'sometimes|required|boolean',
            'glasses' => 'sometimes|required|boolean',
            'pregnant' => 'sometimes|required|boolean',
            'smoker' => 'sometimes|required|boolean',
        ];
    }
}
