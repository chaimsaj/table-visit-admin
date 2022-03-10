<?php

namespace App\Http\Requests\Cities;

use Illuminate\Foundation\Http\FormRequest;

class Cities_near_request extends FormRequest
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
            'latitude' => 'required',
            'longitude' => 'required',
            'distance'=>  'nullable|integer'
        ];
    }


    public function messages()
    {
    return [
        'latitude.required' => 'latitude is required',
        'longitude.required' => 'longitude is required',
        'distance.integer' => 'distance must be an integer'
    ];

    }
}
