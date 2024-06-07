<!-- resources/views/invitations/complete.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Complete Your Registration</h1>
        <form action="{{ route('invitations.complete.post', $invitation->token) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $invitation->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <label for="file">Upload Document</label>
                <input type="file" name="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Complete Registration</button>
        </form>
    </div>
@endsection
