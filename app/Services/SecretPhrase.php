<?php

namespace App\Services;

use Faker\Factory;

class SecretPhrase
{
    /**
    The constructor is private so that methods are only called statically
     */
    protected function __construct()
    {
    }

    public static function create(): string
    {
        return Factory::create(config('app.faker_locale'))->realText(50);
    }
}
