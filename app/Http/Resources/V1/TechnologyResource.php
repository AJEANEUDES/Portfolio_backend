<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TechnologyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');
        $locale = substr($locale, 0, 2);

        // Récupérer la description traduite ou fallback sur la version par défaut
        $description = $this->description;
        if ($this->description_translatable) {
            $translations = is_string($this->description_translatable)
                ? json_decode($this->description_translatable, true)
                : $this->description_translatable;

            if (is_array($translations) && isset($translations[$locale])) {
                $description = $translations[$locale];
            }
        }

        return [
            'slug'        => $this->slug,
            'name'        => $this->name,
            'description' => $description,
            'icon'        => $this->icon ? asset('storage/' . $this->icon) : null,
        ];
    }
}