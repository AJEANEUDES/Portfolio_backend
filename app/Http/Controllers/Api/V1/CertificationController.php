<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CertificationResource;
use App\Models\Certification;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CertificationController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return CertificationResource::collection(
            Certification::active()->ordered()->get()
        );
    }
}