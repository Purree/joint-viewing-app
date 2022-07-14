<?php

namespace App\Services\Secrets;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class TwoFactorSecret extends Secret
{
    #[ArrayShape(['phrase' => 'string', 'hash' => 'string'])]
    public static function create(): array
    {
        $secretPhrase = Str::random(10).'-'.Str::random(10);

        return ['phrase' => $secretPhrase, 'hash' => Hash::make($secretPhrase)];
    }
}
