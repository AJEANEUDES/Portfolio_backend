<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PublicationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PublicationResource;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PublicationController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Publication::active()
            ->ordered()
            ->with(['project', 'categories', 'tags']);

        if ($request->has('type')) {
            $type = PublicationType::tryFrom($request->type);
            if ($type) {
                $query->byType($type);
            }
        }

        return PublicationResource::collection($query->get());
    }
}