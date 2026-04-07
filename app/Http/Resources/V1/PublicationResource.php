<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        return [
            'slug'        => $this->slug,
            'title'       => $this->getTranslatedOrDefault('title', $locale),
            'authors'     => $this->authors,
            'type'        => [
                'value' => $this->type->value,
                'label' => $this->type->label(),
            ],
            'venue'       => $this->venue,
            'year'        => $this->year,
            'doi_url'     => $this->doi_url,
            'pdf_file'    => $this->pdf_file ? asset('storage/' . $this->pdf_file) : null,
            'abstract'    => $this->getTranslatedOrDefault('abstract', $locale),
            'bibtex'      => $this->bibtex,
            'is_featured' => $this->is_featured,
            'project'     => $this->when(
                $this->relationLoaded('project') && $this->project,
                fn () => [
                    'slug' => $this->project->slug,
                    'name' => $this->project->name,
                ]
            ),
            'categories'  => CategoryResource::collection($this->whenLoaded('categories')),
            'tags'        => TagResource::collection($this->whenLoaded('tags')),
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