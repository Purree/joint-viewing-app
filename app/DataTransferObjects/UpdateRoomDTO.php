<?php

namespace App\DataTransferObjects;

class UpdateRoomDTO
{
    public function __construct(
        public readonly string $name,
        public readonly bool $isClosed,
        public readonly bool $isPrivate,
        public readonly bool $canEveryoneControl,
        public readonly ?string $password = null
    ) {
    }
}
