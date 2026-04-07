<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TrackPageViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url'      => ['required', 'string', 'max:500'],
            'referrer' => ['nullable', 'string', 'max:500'],
        ];
    }
}