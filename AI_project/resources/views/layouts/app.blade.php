<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BookMyShow - Book Movie Tickets Online')</title>
    @if (file_exists(public_path('build/manifest.json')))
        @vite('resources/css/app.css')
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1280px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('movies.index') }}" class="flex items-center gap-2 text-2xl font-bold text-red-600">
                        <span class="text-3xl">🎬</span>
                        <span>BookMyShow</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('movies.index') }}" class="text-gray-700 hover:text-red-600 transition font-semibold">
                        Movies
                    </a>
                    
                    @auth
                        <a href="{{ route('bookings.my-bookings') }}" class="text-gray-700 hover:text-red-600 transition font-semibold">
                            My Bookings
                        </a>
                        <div class="relative group">
                            <button class="text-gray-700 hover:text-red-600 transition font-semibold flex items-center gap-2">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </button>
                            <div class="absolute right-0 w-48 bg-white rounded-lg shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition z-50">
                                <form action="{{ route('logout') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-red-600 transition font-semibold">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                            Sign Up
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <button id="mobileMenuBtn" class="md:hidden text-gray-700 hover:text-red-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile menu -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 space-y-2">
                <a href="{{ route('movies.index') }}" class="block px-4 py-2 text-gray-700 hover:text-red-600 transition font-semibold">
                    Movies
                </a>
                @auth
                    <a href="{{ route('bookings.my-bookings') }}" class="block px-4 py-2 text-gray-700 hover:text-red-600 transition font-semibold">
                        My Bookings
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:text-red-600 transition font-semibold">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 hover:text-red-600 transition font-semibold">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-700 hover:text-red-600 transition font-semibold">
                        Sign Up
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white font-bold mb-4">About BookMyShow</h3>
                    <p class="text-sm">Your trusted platform for booking movie tickets online.</p>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Quick Links</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="{{ route('movies.index') }}" class="hover:text-white transition">Movies</a></li>
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Support</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Cancellation Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-bold mb-4">Follow Us</h3>
                    <ul class="text-sm space-y-2">
                        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                        <li><a href="#" class="hover:text-white transition">Twitter</a></li>
                        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 text-center text-sm">
                <p>&copy; 2025 BookMyShow. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
