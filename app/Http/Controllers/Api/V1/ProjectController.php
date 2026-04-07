<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ProjectCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Project::active()
            ->ordered()
            ->with(['technologies', 'tags']);

        if ($request->has('category')) {
            $category = ProjectCategory::tryFrom($request->category);
            if ($category) {
                $query->byCategory($category);
            }
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        return ProjectResource::collection($query->get());
    }

    public function show(Project $project): ProjectResource
    {
        $project->load(['technologies', 'tags', 'publications']);

        return new ProjectResource($project);
    }
}