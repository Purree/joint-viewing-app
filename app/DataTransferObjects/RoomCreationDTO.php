<?php

namespace App\DataTransferObjects;

class RoomCreationDTO
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
}
