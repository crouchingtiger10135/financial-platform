@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome to Fin Platform</h1>
    <p class="text-gray-600 mb-8">Manage your financial compliance and client onboarding seamlessly.</p>
    <div class="flex justify-center">
        <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2">Get Started</a>
        <a href="{{ route('login') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mx-2">Login</a>
    </div>
</div>
@endsection
