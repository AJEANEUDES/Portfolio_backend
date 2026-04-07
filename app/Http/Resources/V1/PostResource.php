<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'            => $this->slug,
            'title'           => $this->getTranslatedOrDefault('title', $locale),
            'cover_image'     => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'excerpt'         => $this->getTranslatedOrDefault('excerpt', $locale),
            'content'         => $this->when(
                $request->routeIs('api.v1.posts.show'),
                fn () => $this->getTranslatedOrDefault('content', $locale)
            ),
            'status'          => $this->status->value,
            'published_at'    => $this->published_at?->toISOString(),
            'reading_time'    => $this->reading_time,
            'categories'      => CategoryResource::collection($this->whenLoaded('categories')),
            'tags'            => TagResource::collection($this->whenLoaded('tags')),
            'author'          => $this->when(
                $this->relationLoaded('author') && $this->author,
                fn () => [
                    'name' => $this->author->name,
                ]
            ),
            'seo' => $this->when(
                $request->routeIs('api.v1.posts.show'),
                fn () => [
                    'title'       => $this->getTranslatedOrDefault('seo_title', $locale) ?? $this->getTranslatedOrDefault('title', $locale),
                    'description' => $this->getTranslatedOrDefault('seo_description', $locale) ?? $this->getTranslatedOrDefault('excerpt', $locale),
                ]
            ),
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