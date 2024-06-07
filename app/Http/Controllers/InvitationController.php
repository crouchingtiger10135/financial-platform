<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:invitations,email',
        ]);

        $token = Str::random(60);
        $invitation = Invitation::create([
            'email' => $request->email,
            'token' => $token,
        ]);

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
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $client = Client::create($request->except('file'));

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('clients', 'public');
            Document::create([
                'client_id' => $client->id,
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_path' => $filePath,
            ]);
        }

        $invitation->delete();

        return redirect()->route('clients.index')->with('status', 'Client onboarding completed successfully.');
    }
}