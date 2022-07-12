<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoginUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth('sanctum')->guest();
    }

    #[ArrayShape(['email' => 'string', 'password' => 'string', 'token' => 'string'])]
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'token' => '',
        ];
    }
}
