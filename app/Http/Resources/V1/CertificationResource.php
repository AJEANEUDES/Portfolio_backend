<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = substr($request->header('Accept-Language', 'fr'), 0, 2);

        return [
            'slug'             => $this->slug,
            'name'             => $this->translated('name', $locale),
            'issuer'           => $this->issuer,
            'issuer_logo'      => $this->issuer_logo ? asset('storage/' . $this->issuer_logo) : null,
            'badge_image'      => $this->badge_image ? asset('storage/' . $this->badge_image) : null,
            'category'         => [
                'value' => $this->category->value,
                'label' => $this->category->label(),
            ],
            'credential_id'    => $this->credential_id,
            'verification_url' => $this->verification_url,
            'issued_date'      => $this->issued_date?->format('Y-m-d'),
            'issued_date_formatted' => $this->issued_date?->translatedFormat('F Y'),
            'expiration_date'  => $this->expiration_date?->format('Y-m-d'),
            'expiration_date_formatted' => $this->expiration_date?->translatedFormat('F Y'),
            'is_expired'       => $this->is_expired,
            'is_valid'         => $this->is_valid,
            'description'      => $this->translated('description', $locale),
            'skills'           => $this->skills ?? [],
            'is_featured'      => $this->is_featured,
        ];
    }

    private function translated(string $field, string $locale): ?string
    {
        $transField = $field . '_translatable';
        if ($this->{$transField}) {
            $translations = is_string($this->{$transField})
                ? json_decode($this->{$transField}, true)
                : $this->{$transField};
            if (is_array($translations) && isset($translations[$locale]) && !empty($translations[$locale])) {
                return $translations[$locale];
            }
        }
        return $this->{$field};
    }
}