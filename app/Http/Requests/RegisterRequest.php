<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::unique('users')],
            'username' => ['required', 'string', 'max:20'],
            'name' => ['sometimes', 'required', 'string'],
            'password' => ['required', 'confirmed']
        ];
    }
}
