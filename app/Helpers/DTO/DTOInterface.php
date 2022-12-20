<?php

namespace App\Helpers\DTO;

use Illuminate\Http\Request;

interface DTOInterface
{
    public static function fromRequest(Request $request): static;
}
