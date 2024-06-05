<nav class="bg-white shadow mb-4">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-xl font-bold">
            <a href="{{ route('welcome') }}" class="text-blue-500 hover:text-blue-700">Fin Platform</a>
        </div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="ml-4 text-gray-700">Dashboard</a>
                <a href="{{ route('clients.index') }}" class="ml-4 text-gray-700">Clients</a>
                <form method="POST" action="{{ route('logout') }}" class="inline ml-4">
                    @csrf
                    <button type="submit" class="text-gray-700">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="ml-4 text-gray-700">Login</a>
                <a href="{{ route('register') }}" class="ml-4 text-gray-700">Register</a>
            @endauth
        </div>
    </div>
</nav>
