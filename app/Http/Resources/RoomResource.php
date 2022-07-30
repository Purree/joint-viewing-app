<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'owner' => new UserResource($this->whenLoaded('owner')),
            'name' => $this->name,
            'link' => $this->link,
            'is_closed' => $this->is_closed,
            'everyone_control' => $this->everyone_control,
            'is_private' => $this->is_private,
        ];
    }
}
