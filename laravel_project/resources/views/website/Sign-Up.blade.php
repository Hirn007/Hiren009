@extends('website.layout.structure')

@section('content')

<div class="container">
    <h2>Sign Up</h2>

    <form method="POST" action="/sign-up">
        @csrf

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <br>

        <button type="submit" class="btn btn-success">Sign Up</button>

        <p>
            Already have account?
            <a href="/login">Login</a>
        </p>

    </form>
</div>

@endsection