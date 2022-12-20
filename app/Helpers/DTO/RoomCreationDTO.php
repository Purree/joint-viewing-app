<?php

namespace App\Helpers\DTO;

use Illuminate\Http\Request;

class RoomCreationDTO implements DTOInterface
{
    public function __construct(
        public readonly string $name,
        public readonly bool $isClosed,
        public readonly bool $isPrivate,
        public readonly bool $canEveryoneControl,
        public readonly ?string $link = null,
        public readonly ?string $password = null
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new static(
            $request->get('name'),
            $request->get('is_closed'),
            $request->get('is_private'),
            $request->get('can_everyone_control'),
            $request->get('link'),
            $request->get('password')
        );
    }
}
