<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SocialLinkResource;
use App\Models\SocialLink;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SocialLinkController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return SocialLinkResource::collection(
            SocialLink::active()->ordered()->get()
        );
    }
}