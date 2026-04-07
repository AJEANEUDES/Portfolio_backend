<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TrackPageViewRequest;
use App\Models\PageView;
use Illuminate\Http\JsonResponse;

class TrackingController extends Controller
{
    public function store(TrackPageViewRequest $request): JsonResponse
    {
        PageView::create([
            'url'         => $request->url,
            'referrer'    => $request->referrer,
            'country'     => null, // GeoIP sera ajouté en production
            'device_type' => $this->detectDeviceType($request->userAgent()),
            'browser'     => $this->detectBrowser($request->userAgent()),
            'created_at'  => now(),
        ]);

        return response()->json(['status' => 'ok'], 201);
    }

    private function detectDeviceType(?string $userAgent): string
    {
        if (!$userAgent) return 'unknown';

        if (preg_match('/Mobile|Android|iPhone|iPad/i', $userAgent)) {
            return str_contains(strtolower($userAgent), 'ipad') ? 'tablet' : 'mobile';
        }

        return 'desktop';
    }

    private function detectBrowser(?string $userAgent): string
    {
        if (!$userAgent) return 'unknown';

        if (str_contains($userAgent, 'Firefox')) return 'Firefox';
        if (str_contains($userAgent, 'Edg'))     return 'Edge';
        if (str_contains($userAgent, 'Chrome'))  return 'Chrome';
        if (str_contains($userAgent, 'Safari'))  return 'Safari';
        if (str_contains($userAgent, 'Opera'))   return 'Opera';

        return 'other';
    }
}