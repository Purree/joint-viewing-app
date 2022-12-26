<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SynchronizationRequest extends FormRequest
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
            'time' => 'required|numeric|min:0',
            'is_paused' => 'required|boolean',
            'playback_rate' => 'required|numeric|min:0.07|max:16',
            'synchronizer_timestamp' => 'required|numeric|min:0',
            'additional_data' => 'nullable|array',
        ];
    }
}
