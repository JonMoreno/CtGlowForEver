<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationPost extends FormRequest
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
        $militaryRegex = "/^([01]\d|2[0-3]):?([0-5]\d)$/";
        return [
            'next_appointment' => 'nullable|date',
            'client_id' => 'sometimes|required|numeric',
            'notes' => 'nullable|string|max:255',
            'time' => ["nullable"],

        ];
    }
}
