<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'             => $this->slug,
            'name'             => $this->getTranslatedOrDefault('name', $locale),
            'description'      => $this->getTranslatedOrDefault('description', $locale),
            'long_description' => $this->getTranslatedOrDefault('long_description', $locale),
            'screenshot'       => $this->screenshot ? asset('storage/' . $this->screenshot) : null,
            'category'         => [
                'value' => $this->category->value,
                'label' => $this->category->label(),
            ],
            'website_url'      => $this->website_url,
            'mobile_url'       => $this->mobile_url,
            'github_url'       => $this->github_url,
            'demo_url'         => $this->demo_url,
            'video_url'        => $this->video_url,
            'video_thumbnail'  => $this->video_thumbnail ? asset('storage/' . $this->video_thumbnail) : null,
            'date'             => $this->date?->format('Y-m-d'),
            'is_featured'      => $this->is_featured,
            'technologies'     => TechnologyResource::collection($this->whenLoaded('technologies')),
            'tags'             => TagResource::collection($this->whenLoaded('tags')),
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