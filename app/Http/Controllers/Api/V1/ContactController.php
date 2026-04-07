<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function store(ContactRequest $request): JsonResponse
    {
        // Le champ honeypot "website" doit être vide — sinon c'est un bot
        if ($request->filled('website')) {
            // On retourne un faux succès pour ne pas alerter le bot
            return response()->json([
                'message' => 'Message envoyé avec succès.',
            ], 201);
        }

        ContactMessage::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Message envoyé avec succès. Merci !',
        ], 201);
    }
}