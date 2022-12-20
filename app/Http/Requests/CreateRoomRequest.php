<?php

namespace App\Http\Requests;

use App\DataTransferObjects\CreateRoomDTO;
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
            'is_closed' => 'required|boolean',
            'can_everyone_control' => 'required|boolean',
            'is_private' => 'required|boolean',
            'password' => 'string|max:255',
        ];
    }

    public function toDTO(): CreateRoomDTO
    {
        return new CreateRoomDTO(
            name: $this->get('name'),
            isClosed: $this->get('is_closed'),
            isPrivate: $this->get('is_private'),
            canEveryoneControl: $this->get('can_everyone_control'),
            link: $this->get('link'),
            password: $this->get('password')
        );
    }
}
