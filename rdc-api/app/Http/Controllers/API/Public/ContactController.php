<?php

namespace App\Http\Controllers\API\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * Envoyer un message au Président
     */
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        try {
            // Créer le message
            $message = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'city' => $request->city,
                'country' => $request->country ?? 'République Centrafricaine',
                'metadata' => [
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'submitted_at' => now()->toISOString()
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.',
                'data' => [
                    'id' => $message->id,
                    'reference' => 'MSG-' . str_pad($message->id, 6, '0', STR_PAD_LEFT)
                ]
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Erreur création message de contact: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.'
            ], 500);
        }
    }
}
