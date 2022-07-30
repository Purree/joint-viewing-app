<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueResource extends JsonResource
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
            'queued_id' => $this->queued_id,
            'room' => new RoomResource($this->whenLoaded('room')),
            'customer' => new UserResource($this->whenLoaded('customer')),
            'video_url' => $this->video_url,
        ];
    }
}
