<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'         => $this->slug,
            'title'        => $this->getTranslatedOrDefault('title', $locale),
            'description'  => $this->getTranslatedOrDefault('description', $locale),
            'icon'         => $this->icon ? asset('storage/' . $this->icon) : null,
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