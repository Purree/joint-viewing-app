<?php

namespace App\Http\Requests;

use App\Rules\ValidSlug;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'link' => ['string', 'nullable', 'max:255', 'unique:rooms', new ValidSlug()],
            'is_closed' => 'in:on',
            'can_everyone_control' => 'in:on',
            'is_private' => 'in:on',
            'password' => 'string|max:255|required_with:is_closed',
        ];
    }
}
