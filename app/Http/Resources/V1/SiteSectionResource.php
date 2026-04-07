<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');
        $locale = substr($locale, 0, 2);

        return [
            'key'      => $this->key,
            'title'    => $this->translated('title', $locale),
            'subtitle' => $this->translated('subtitle', $locale),
            'order'    => $this->order,
            'is_active'=> $this->is_active,
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