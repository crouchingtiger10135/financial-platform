@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Clients Dashboard</h1>
        <div class="flex space-x-2">
            <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Client</a>
            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-bs-toggle="modal" data-bs-target="#sendInvitationModal">
                Send Invitation
            </button>
        </div>
    </div>

    @if(session('status'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <!-- Send Invitation Modal -->
    <div class="modal fade" id="sendInvitationModal" tabindex="-1" aria-labelledby="sendInvitationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendInvitationModalLabel">Send Invitation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('send-invitation') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Invitation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-xl font-semibold">Total Clients: {{ $clients->total() }}</h2>
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b text-left">Name</th>
                    <th class="py-2 px-4 border-b text-left">708 Status</th>
                    <th class="py-2 px-4 border-b text-left">Identity</th>
                    <th class="py-2 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $client->name }}</td>
                        <td class="py-2 px-4 border-b">
                            <span class="{{ $client->hasUploadedDocument() ? 'text-green-500' : 'text-red-500' }}">
                                {{ $client->hasUploadedDocument() ? 'Complete' : 'Incomplete' }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <span class="{{ $client->isIdentityVerified() ? 'text-green-500' : 'text-red-500' }}">
                                {{ $client->isIdentityVerified() ? 'Complete' : 'Incomplete' }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-bs-toggle="modal" data-bs-target="#actionsModal-{{ $client->id }}">
                                Actions
                            </button>

                            <!-- Actions Modal -->
                            <div class="modal fade" id="actionsModal-{{ $client->id }}" tabindex="-1" aria-labelledby="actionsModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="actionsModalLabel">Actions for {{ $client->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('clients.update', $client->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file" class="form-label">Add Document</label>
                                                    <input type="file" class="form-control" id="file" name="file">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </form>
                                            <hr>
                                            <h5>Documents</h5>
                                            <ul>
                                                @foreach ($client->documents as $document)
                                                    <li>
                                                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">{{ $document->file_name }}</a>
                                                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <hr>
                                            <button type="button" class="btn btn-primary start-verification" data-client-id="{{ $client->id }}">Start Identity Verification</button>
                                            <hr>
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete Client</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $clients->links() }}
        </div>
    </div>
</div>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.start-verification').forEach(button => {
            button.addEventListener('click', function() {
                const clientId = this.getAttribute('data-client-id');

                fetch('/create-verification-session', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ client_id: clientId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error('Error:', data.error);
                    } else {
                        const stripe = Stripe('{{ config('services.stripe.key') }}');
                        stripe.redirectToCheckout({ sessionId: data.sessionId });
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endsection
