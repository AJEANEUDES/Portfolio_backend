<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->header('Accept-Language', 'fr');

        $name = $this->name;
        if ($this->name_translatable) {
            $translations = is_string($this->name_translatable)
                ? json_decode($this->name_translatable, true)
                : $this->name_translatable;
            if (isset($translations[$locale])) {
                $name = $translations[$locale];
            }
        }

        return [
            'slug' => $this->slug,
            'name' => $name,
        ];
    }
}