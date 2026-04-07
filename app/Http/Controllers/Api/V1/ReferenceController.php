<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ReferenceResource;
use App\Models\Reference;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReferenceController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ReferenceResource::collection(
            Reference::active()->ordered()->get()
        );
    }
}