<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ExperienceCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ExperienceController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Experience::active()
            ->ordered()
            ->with('technologies');

        if ($request->has('category')) {
            $category = ExperienceCategory::tryFrom($request->category);
            if ($category) {
                $query->byCategory($category);
            }
        }

        return ExperienceResource::collection($query->get());
    }
}