<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class YouTubeVideo implements InvokableRule
{
    public function __invoke($attribute, $value, $fail): void
    {
        if (preg_match(
                '/http(?:s?):\/\/(?:www\.)?youtu(?:be\.com\/watch\?v=|\.be\/)([\w\-_]*)(&(amp;)?[\w?=]*)?/',
                $value
            ) !== 1) {
            $fail('The :attribute may be youtube video url.');
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
