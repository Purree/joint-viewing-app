<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoveryPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth('sanctum')->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
            'secret' => 'required',
            'password' => 'required|confirmed',
        ];
    }
}
