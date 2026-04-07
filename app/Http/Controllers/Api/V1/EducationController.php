<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EducationResource;
use App\Models\Education;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EducationController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $educations = Education::active()
            ->ordered()
            ->with('technologies')
            ->get();

        return EducationResource::collection($educations);
    }
}