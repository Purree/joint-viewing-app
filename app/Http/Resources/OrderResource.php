<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'room' => new RoomResource($this->whenLoaded('room')),
            'customer' => new UserResource($this->customer),
            'video_url' => $this->video_url,
        ];
    }
}
