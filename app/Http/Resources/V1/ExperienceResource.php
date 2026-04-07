<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'         => $this->slug,
            'position'     => $this->getTranslatedOrDefault('position', $locale),
            'company'      => $this->getTranslatedOrDefault('company', $locale),
            'company_logo' => $this->company_logo ? asset('storage/' . $this->company_logo) : null,
            'company_url'  => $this->company_url,
            'start_date'   => $this->start_date->format('Y-m-d'),
            'end_date'     => $this->end_date?->format('Y-m-d'),
            'is_present'   => $this->is_present,
            'period'       => $this->period,
            'category'     => [
                'value' => $this->category->value,
                'label' => $this->category->label(),
            ],
            'description'  => $this->getTranslatedOrDefault('description', $locale),
            'location'     => $this->location,
            'work_type'    => [
                'value' => $this->work_type->value,
                'label' => $this->work_type->label(),
            ],
            'technologies' => TechnologyResource::collection($this->whenLoaded('technologies')),
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