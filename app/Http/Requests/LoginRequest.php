<?php

namespace App\Http\Requests;

use App\DTO\LoginDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }


    public function covertToDto(): LoginDto
    {
        $data = $this->validated();

        return new LoginDto($data['email'], $data['password']);
    }
}
