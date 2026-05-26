<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="text-xl font-bold text-white mb-6 text-center font-display">Sign In</h2>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all">
            @error('email')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
            <input id="password" type="password" name="password" required
                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-brand-500 transition-all">
            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label class="flex items-center gap-2 text-sm text-gray-400">
                <input type="checkbox" name="remember" class="rounded border-gray-600 bg-white/5">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-brand-500 hover:text-brand-400">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="w-full bg-brand-600 hover:bg-brand-500 text-white py-3 rounded-xl font-medium transition-all btn-glow">
            Sign In
        </button>

        <p class="text-center text-gray-500 text-sm mt-4">
            Don't have an account? <a href="{{ route('register') }}" class="text-brand-500 hover:text-brand-400">Register</a>
        </p>
    </form>
</x-guest-layout>
