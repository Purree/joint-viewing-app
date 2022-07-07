<?php

namespace App\Services;

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class Secret
{
    /**
     * The constructor is private so that methods are only called statically
     */
    protected function __construct()
    {
    }

    #[ArrayShape(['phrase' => 'string', 'hash' => 'string'])]
    public static function create(): array
    {
        $secretPhrase = Factory::create(config('app.faker_locale'))->realText(50);

        return ['phrase' => $secretPhrase, 'hash' => Hash::make($secretPhrase)];
    }
}
