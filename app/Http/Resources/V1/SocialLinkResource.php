<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialLinkResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'platform' => [
                'value' => $this->platform->value,
                'label' => $this->platform->label(),
                'icon'  => $this->platform->icon(),
            ],
            'url'   => $this->url,
            'label' => $this->label,
        ];
    }
}