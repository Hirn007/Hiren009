<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Creator Merch Store - Premium merchandise from your favorite creators">

    <title>@yield('title', config('app.name', 'Creator Merch Store'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f4ff',
                            100: '#dbe4ff',
                            200: '#bac8ff',
                            300: '#91a7ff',
                            400: '#748ffc',
                            500: '#5c7cfa',
                            600: '#4c6ef5',
                            700: '#4263eb',
                            800: '#3b5bdb',
                            900: '#364fc7',
                        },
                        accent: {
                            400: '#ff6b6b',
                            500: '#fa5252',
                            600: '#f03e3e',
                        },
                        dark: {
                            700: '#1a1a2e',
                            800: '#16162a',
                            900: '#0f0f23',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); }
        .gradient-text { background: linear-gradient(135deg, #748ffc, #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .btn-glow { box-shadow: 0 0 20px rgba(92, 124, 250, 0.4); }
        .btn-glow:hover { box-shadow: 0 0 30px rgba(92, 124, 250, 0.6); }
        .fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .slide-up { animation: slideUp 0.5s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .pulse-dot { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    </style>

    @yield('styles')
</head>
<body class="bg-dark-900 text-white min-h-screen">

    <!-- Navigation Bar -->
    <nav class="glass sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center space-x-2 group">
                    <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-accent-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-xl gradient-text">CreatorMerch</span>
                </a>

                <!-- Nav Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white transition-colors text-sm font-medium {{ request()->routeIs('products.index') ? 'text-white' : '' }}">
                        🛍️ Store
                    </a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-white' : '' }}">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('products.create') }}" class="text-gray-300 hover:text-white transition-colors text-sm font-medium">
                        ➕ Add Merch
                    </a>
                    <a href="{{ route('orders.index') }}" class="text-gray-300 hover:text-white transition-colors text-sm font-medium">
                        📦 Orders
                    </a>
                    @endauth
                </div>

                <!-- Auth Section -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-brand-400 to-brand-600 rounded-full flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-300 hidden sm:block">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-accent-400 transition-colors text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors text-sm">Login</a>
                        <a href="{{ route('register') }}" class="bg-brand-600 hover:bg-brand-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all btn-glow">
                            Register
                        </a>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="md:hidden text-gray-300 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-white/10 pb-4">
            <div class="px-4 pt-3 space-y-2">
                <a href="{{ route('products.index') }}" class="block text-gray-300 hover:text-white py-2 text-sm">🛍️ Store</a>
                @auth
                <a href="{{ route('dashboard') }}" class="block text-gray-300 hover:text-white py-2 text-sm">📊 Dashboard</a>
                <a href="{{ route('products.create') }}" class="block text-gray-300 hover:text-white py-2 text-sm">➕ Add Merch</a>
                <a href="{{ route('orders.index') }}" class="block text-gray-300 hover:text-white py-2 text-sm">📦 Orders</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4 fade-in">
            <div class="bg-green-500/20 border border-green-500/30 text-green-300 px-6 py-3 rounded-xl text-sm flex items-center justify-between">
                <span>✅ {{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-white">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4 fade-in">
            <div class="bg-red-500/20 border border-red-500/30 text-red-300 px-6 py-3 rounded-xl text-sm flex items-center justify-between">
                <span>❌ {{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-white">&times;</button>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main class="fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 mt-20">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-accent-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-lg gradient-text">CreatorMerch</span>
                    </div>
                    <p class="text-gray-500 text-sm">Premium merchandise from your favorite content creators.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-300 mb-3">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">Browse Store</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Creator Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-300 mb-3">API Access</h4>
                    <p class="text-gray-500 text-sm">Access our product catalog via REST API</p>
                    <code class="text-brand-400 text-xs mt-2 block">GET /api/products</code>
                </div>
            </div>
            <div class="border-t border-white/5 mt-8 pt-8 text-center text-gray-600 text-sm">
                &copy; {{ date('Y') }} Creator Merch Store. Built with Laravel {{ app()->version() }}.
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
