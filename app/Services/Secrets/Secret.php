<?php

namespace App\Services\Secrets;

use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use JetBrains\PhpStorm\ArrayShape;

class Secret implements SecretInterface
{
    /**
     * The constructor is private so that methods are only called statically
     */
    protected function __construct()
    {
    }

    #[ArrayShape(['phrase' => 'mixed', 'hash' => 'mixed'])]
    public static function create(): array
    {
        $secretPhrase = Factory::create(config('app.faker_locale'))->realText(50);

        return ['phrase' => $secretPhrase, 'hash' => Hash::make($secretPhrase)];
    }
}
