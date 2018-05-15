<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientPost extends FormRequest
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
            'first_name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string' ,
            'mid_initial' => 'nullable|string',
            'dob' => 'sometimes|required|date',
            'email' => 'nullable|email',
            'street' => 'sometimes|required|string',
            'apt_floor' => 'sometimes|nullable|string',
            'city' => 'sometimes|required|string',
            'state' => 'sometimes|required|string',
            'zip' => 'sometimes|required|digits:5',
            'work_phone' => ["nullable"],
            'emergency_phone' => ["nullable"],
            'cellular' => ["nullable"],
            'occupation' => 'nullable|string',
            'gender' => 'sometimes|required|string|max:7',
            'first_facial' => 'sometimes|required|boolean',
            'visit_reason' => 'nullable|string',
            'image' => 'sometimes|required|string',
            'file' => 'sometimes|required|image',

        ];
    }
}
