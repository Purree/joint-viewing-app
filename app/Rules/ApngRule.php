<?php

namespace App\Rules;

use App\Services\ImageDecorator;
use Illuminate\Contracts\Validation\Rule;

class ApngRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return ImageDecorator::checkIsAPNG($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The image is animated png.';
    }
}
