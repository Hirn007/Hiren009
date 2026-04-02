<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ url('admin/dist/styles.css') }}">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" action="{{ route('admin.loginCheck') }}">
        @csrf
        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

        @if(session('error'))
            <div class="mb-4 text-red-500">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="mb-4 text-green-500">{{ session('success') }}</div>
        @endif

        <div class="mb-4">
            <label for="username" class="block mb-1">Username</label>
            <input type="text" name="username" id="username" required class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1">Password</label>
            <input type="password" name="password" id="password" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded">Login</button>
    </form>
</body>
</html>