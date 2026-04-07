<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'             => $this->slug,
            'degree'           => $this->getTranslatedOrDefault('degree', $locale),
            'institution'      => $this->getTranslatedOrDefault('institution', $locale),
            'institution_logo' => $this->institution_logo ? asset('storage/' . $this->institution_logo) : null,
            'institution_url'  => $this->institution_url,
            'start_date'       => $this->start_date->format('Y-m-d'),
            'end_date'         => $this->end_date?->format('Y-m-d'),
            'is_present'       => $this->is_present,
            'period'           => $this->period,
            'description'      => $this->getTranslatedOrDefault('description', $locale),
            'mention'          => $this->mention,
            'location'         => $this->location,
            'technologies'     => TechnologyResource::collection($this->whenLoaded('technologies')),
        ];
    }

    private function getTranslatedOrDefault(string $field, string $locale): ?string
    {
        $transField = $field . '_translatable';
        if ($this->{$transField}) {
            $translations = is_string($this->{$transField})
                ? json_decode($this->{$transField}, true)
                : $this->{$transField};
            if (isset($translations[$locale])) {
                return $translations[$locale];
            }
        }
        return $this->{$field};
    }
}