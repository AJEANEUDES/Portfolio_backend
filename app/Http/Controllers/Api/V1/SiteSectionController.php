<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SiteSectionResource;
use App\Models\SiteSection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SiteSectionController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return SiteSectionResource::collection(
            SiteSection::active()->ordered()->get()
        );
    }
}