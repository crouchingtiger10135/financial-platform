<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class InvitationController extends Controller
{
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $token = Str::random(60);

        // Find existing invitation or create a new one
        $invitation = Invitation::updateOrCreate(
            ['email' => $request->email],
            ['token' => $token]
        );

        Mail::to($request->email)->send(new InvitationMail($invitation));

        return back()->with('status', 'Invitation sent successfully.');
    }

    public function showInvitationForm($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        return view('invitations.complete', compact('invitation'));
    }

    public function completeInvitation(Request $request, $token)
    {
        // Find the invitation by token
        $invitation = Invitation::where('token', $token)->firstOrFail();

        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // Create a new client
        $client = Client::create($request->except('file'));

        // Handle file upload if present
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('clients', 'public');
            Document::create([
                'client_id' => $client->id,
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_path' => $filePath,
            ]);
        }

        // Delete the invitation
        $invitation->delete();

        // Redirect to clients index with success message
        return redirect()->route('clients.index')->with('status', 'Client onboarding completed successfully.');
    }
}
