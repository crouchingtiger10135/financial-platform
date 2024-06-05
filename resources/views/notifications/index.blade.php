@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold">Notifications</h1>
    <ul class="list-disc pl-5 mt-4">
        @forelse ($notifications as $notification)
            <li class="{{ $notification->read_at ? 'text-gray-500' : 'text-gray-900' }}">
                {{ $notification->data['message'] ?? 'No message available' }}
                @if (!$notification->read_at)
                    <a href="{{ route('notifications.read', $notification->id) }}" class="text-blue-500">Mark as read</a>
                @endif
            </li>
        @empty
            <li>No notifications</li>
        @endforelse
    </ul>
</div>
@endsection
