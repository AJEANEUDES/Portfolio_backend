<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $locale = substr($request->header('Accept-Language', 'fr'), 0, 2);

        $translations = Translation::all()->mapWithKeys(function ($t) use ($locale) {
            return [$t->key => $t->getTranslated($locale)];
        });

        return response()->json(['data' => $translations]);
    }
}