<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'name' => $this->name,
                'email' => $this->email,
                'avatar' => $this->avatar,
            ] +
            (
            \Gate::check('use-authenticated-route', [$request->user(), $this])
                ?
                [
                    'use_two_factor' => $this->hasEnabledTwoFactorAuthentication(),
                    'current_room' => $this->current_room,
                    'created_room' => $this->created_room,
                ]
                :
                []
            );
    }
}
