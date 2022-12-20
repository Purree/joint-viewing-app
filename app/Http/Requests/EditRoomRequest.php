<?php

namespace App\Http\Requests;

use App\DataTransferObjects\UpdateRoomDTO;
use Illuminate\Foundation\Http\FormRequest;

class EditRoomRequest extends FormRequest
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
            'name' => 'string|max:255',
            'is_closed' => 'required|boolean',
            'can_everyone_control' => 'required|boolean',
            'is_private' => 'required|boolean',
            'password' => 'string|max:255',
        ];
    }

    public function toDTO(): UpdateRoomDTO
    {
        return new UpdateRoomDTO(
            name: $this->get('name'),
            isClosed: $this->get('is_closed'),
            isPrivate: $this->get('is_private'),
            canEveryoneControl: $this->get('can_everyone_control'),
            password: $this->get('password'),
        );
    }
}
