<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|min:3|email|unique:users',
            'password' => 'required|min:6|max:20',
        ];
    }
}
