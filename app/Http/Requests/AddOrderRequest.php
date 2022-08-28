<?php

namespace App\Http\Requests;

use App\Rules\YouTubeVideo;
use Illuminate\Foundation\Http\FormRequest;

class AddOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'video_url' => ['required', 'string', 'max:255', new YouTubeVideo()],
        ];
    }
}
