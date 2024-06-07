@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Total Clients</h2>
            <p class="text-3xl">{{ $totalClients }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Pending Invitations</h2>
            <p class="text-3xl">{{ $pendingInvitations }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Documents Uploaded</h2>
            <p class="text-3xl">{{ $documentsUploaded }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="text-xl font-semibold">Verification Complete</h2>
            <p class="text-3xl">{{ $verificationComplete }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
        <ul>
            @foreach ($recentActivities as $activity)
                <li class="mb-2">{{ $activity }}</li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
        <div class="flex space-x-4">
            <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Client</a>
            <a href="{{ route('send-invitation') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Send Invitation</a>
            <a href="{{ route('clients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">View All Clients</a>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">Recent Documents</h2>
        <ul>
            @foreach ($recentDocuments as $document)
                <li class="mb-2">
                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">{{ $document->file_name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
