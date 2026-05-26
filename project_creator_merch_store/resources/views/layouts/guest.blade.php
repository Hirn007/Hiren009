{{-- Guest Layout for Auth Pages - Uses Tailwind CDN --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Creator Merch Store') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { sans: ['Inter', 'sans-serif'], display: ['Outfit', 'sans-serif'] },
                colors: { brand: { 500: '#5c7cfa', 600: '#4c6ef5', 700: '#4263eb' }, accent: { 400: '#ff6b6b', 500: '#fa5252' }, dark: { 700: '#1a1a2e', 800: '#16162a', 900: '#0f0f23' } }
            }}
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text { background: linear-gradient(135deg, #748ffc, #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); }
        .btn-glow { box-shadow: 0 0 20px rgba(92, 124, 250, 0.4); }
    </style>
</head>
<body class="bg-dark-900 text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-accent-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <span class="font-display font-bold text-2xl gradient-text">CreatorMerch</span>
            </a>
        </div>
        <div class="glass rounded-2xl p-8">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
