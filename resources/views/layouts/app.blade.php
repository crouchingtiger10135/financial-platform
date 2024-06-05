<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-white shadow mb-4">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center">
                    <div class="text-xl font-bold">
                        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">Fin Platform</a>
                    </div>
                    <div class="block lg:hidden">
                        <button class="mobile-menu-button text-gray-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="hidden lg:flex space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700">Dashboard</a>
                            <a href="{{ route('clients.index') }}" class="text-gray-700">Clients</a>
                            <a href="{{ route('notifications.index') }}" class="text-gray-700">Notifications ({{ auth()->user()->unreadNotifications->count() }})</a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-700">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-700">Register</a>
                        @endauth
                    </div>
                </div>
                <div class="mobile-menu hidden lg:hidden mt-4">
                    <ul class="space-y-4">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="block text-gray-700">Dashboard</a></li>
                            <li><a href="{{ route('clients.index') }}" class="block text-gray-700">Clients</a></li>
                            <li><a href="{{ route('notifications.index') }}" class="block text-gray-700">Notifications ({{ auth()->user()->unreadNotifications->count() }})</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="block text-gray-700">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}" class="block text-gray-700">Login</a></li>
                            <li><a href="{{ route('register') }}" class="block text-gray-700">Register</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            @yield('content')
        </main>
    </div>

    <script>
        // Toggle the mobile menu
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
</body>
</html>
