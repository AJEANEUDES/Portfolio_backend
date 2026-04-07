<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = substr($request->header('Accept-Language', 'fr'), 0, 2);

        return [
            'name'         => $this->translated('name', $locale),
            'title'        => $this->translated('title', $locale),
            'bio'          => $this->translated('bio', $locale),
            'photo'        => $this->photo ? asset('storage/' . $this->photo) : null,
            'avatar'       => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'cv_file'      => $this->cv_file ? asset('storage/' . $this->cv_file) : null,
            'video_url'    => $this->video_url,
            'email'        => $this->email,
            'hero_phrases' => $this->getHeroPhrases($locale),
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

    private function getHeroPhrases(string $locale): array
    {
        // Priorité aux phrases traduites si disponibles
        if ($this->hero_phrases_translatable) {
            $translations = is_string($this->hero_phrases_translatable)
                ? json_decode($this->hero_phrases_translatable, true)
                : $this->hero_phrases_translatable;

            if (is_array($translations) && isset($translations[$locale]) && is_array($translations[$locale]) && count($translations[$locale]) > 0) {
                return $translations[$locale];
            }
        }

        // Fallback : phrases en français
        if ($this->hero_phrases) {
            return is_array($this->hero_phrases) ? $this->hero_phrases : json_decode($this->hero_phrases, true) ?? [];
        }

        return [];
    }
}