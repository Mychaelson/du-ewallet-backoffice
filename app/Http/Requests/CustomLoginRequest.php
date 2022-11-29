<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest;
use Laravel\Fortify\Fortify;

class CustomLoginRequest extends LoginRequest
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
            Fortify::username() => 'required|string|min:3|max:20',
            'password' => 'required|string|min:6|max:20'
        ];
    }
}
