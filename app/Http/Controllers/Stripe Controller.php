<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Identity\VerificationSession;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createVerificationSession(Request $request)
    {
        try {
            $client_id = $request->input('client_id');

            $session = VerificationSession::create([
                'type' => 'document',
                'metadata' => [
                    'client_id' => $client_id,
                    'user_id' => auth()->id(),
                ],
            ]);

            return response()->json(['sessionId' => $session->id]);
        } catch (\Exception $e) {
            Log::error('Error creating Stripe verification session: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create verification session.'], 500);
        }
    }
}
