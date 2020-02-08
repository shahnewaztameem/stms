<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'name' => 'bail | required | max: 100',
            'company' => 'bail | required | max: 100',
            'email' => 'bail | required | email | max: 30 | unique:users',
            'phone_number' => 'bail | required | max: 16 | min: 8',
            'user_type' => 'bail | required ',
            'other_info' => 'bail | required | max: 250',
            'password' => 'bail | required | min: 6 | max: 100 | confirmed'
        ];
    }
}
