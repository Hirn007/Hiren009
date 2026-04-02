@extends('website.layout.structure')

@section('content')

<div class="container" style="max-width: 450px; margin-top:50px;">

    <h2 class="mb-4 text-center">User Login</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ url('login-check') }}">
        @csrf

        <div class="form-group mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="mt-3 text-center">
            Don't have account?
            <a href="{{ url('register') }}">Sign Up</a>
        </p>

    </form>
</div>

@endsection