<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Endpoint public
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:2000', 'min:10'],
            // Honeypot anti-bot — ce champ doit être VIDE
            'website' => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'Le nom est requis.',
            'email.required'   => 'L\'email est requis.',
            'email.email'      => 'L\'email n\'est pas valide.',
            'message.required' => 'Le message est requis.',
            'message.min'      => 'Le message doit contenir au moins 10 caractères.',
            'message.max'      => 'Le message ne peut pas dépasser 2000 caractères.',
            'website.max'      => '',  // Silencieux pour le honeypot
        ];
    }
}