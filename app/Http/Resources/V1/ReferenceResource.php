<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferenceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'                => $this->slug,
            'full_name'           => $this->full_name,
            'title'               => $this->translated('title', $locale),
            'organization'        => $this->translated('organization', $locale),
            'department'          => $this->translated('department', $locale),
            'photo'               => $this->photo ? asset('storage/' . $this->photo) : null,
            'organization_logo'   => $this->organization_logo ? asset('storage/' . $this->organization_logo) : null,
            'relationship'        => $this->translated('relationship', $locale),
            'relationship_period' => $this->relationship_period,
            'testimonial'         => $this->translated('testimonial', $locale),
            'letter_status'       => [
                'value' => $this->letter_status->value,
                'label' => $this->letter_status->label(),
            ],
            'letter_file'         => $this->letter_file ? asset('storage/' . $this->letter_file) : null,
            // Coordonnées : uniquement si show_contact_info est activé
            'contact'             => $this->show_contact_info ? [
                'email'        => $this->email,
                'phone'        => $this->phone,
                'linkedin_url' => $this->linkedin_url,
                'website_url'  => $this->website_url,
            ] : null,
        ];
    }

    private function translated(string $field, string $locale): ?string
    {
        $transField = $field . '_translatable';
        if ($this->{$transField}) {
            $translations = is_string($this->{$transField})
                ? json_decode($this->{$transField}, true)
                : $this->{$transField};
            if (is_array($translations) && isset($translations[$locale])) {
                return $translations[$locale];
            }
        }
        return $this->{$field};
    }
}