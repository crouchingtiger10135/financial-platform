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
            $session = VerificationSession::create([
                'type' => 'document',
                'metadata' => [
                    'user_id' => auth()->id(),
                ],
            ]);

            return response()->json(['sessionId' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
