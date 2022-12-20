<?php

namespace App\Helpers\Secrets;

use JetBrains\PhpStorm\ArrayShape;

interface SecretInterface
{
    #[ArrayShape(['phrase' => 'string', 'hash' => 'string'])]
    public static function create(): array;
}
