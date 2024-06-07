<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Identity\VerificationSession;

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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
