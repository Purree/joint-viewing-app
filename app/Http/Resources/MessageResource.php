<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'room' => new RoomResource($this->room),
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
