<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProfileResource;
use App\Http\Resources\V1\TechnologyResource;
use App\Models\Profile;
use App\Models\Technology;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $profile = Profile::first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not configured'], 404);
        }

        $skills = Technology::active()->ordered()->get();

        return response()->json([
            'data' => [
                'profile' => new ProfileResource($profile),
                'skills'  => TechnologyResource::collection($skills),
            ],
        ]);
    }
}