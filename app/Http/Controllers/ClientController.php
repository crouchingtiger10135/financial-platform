<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Stripe\StripeClient;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email',
            'phone' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $client = Client::create($request->except('file'));

        // Handle file upload
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('clients', 'public');

            // Save file information to the Document model
            Document::create([
                'client_id' => $client->id,
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_path' => $filePath,
            ]);
        }

        return redirect()->route('clients.index')->with('status', 'Client added successfully.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,' . $client->id,
            'phone' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $data = $request->except('file');

        // Handle file upload
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('clients', 'public');

            // Save file information to the Document model
            Document::create([
                'client_id' => $client->id,
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_path' => $filePath,
            ]);
        }

        $client->update($data);

        return redirect()->route('clients.index')->with('status', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('status', 'Client deleted successfully.');
    }

    public function startVerification($clientId)
    {
        $client = Client::findOrFail($clientId);

        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $verificationSession = $stripe->identity->verificationSessions->create([
            'type' => 'document',
            'metadata' => [
                'client_id' => $client->id,
            ],
            'return_url' => route('clients.index'),
        ]);

        return response()->json(['url' => $verificationSession->url]);
    }
}
