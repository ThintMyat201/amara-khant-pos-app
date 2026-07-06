@extends('layouts.guest')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-4 p-sm-5">
            <div class="text-center mb-4">
                <h2 class="h4 mb-1" style="font-weight: 700; color: #111827;">Forgot Your Password?</h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form class="user" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group mb-4">
                    <label for="email" class="small text-muted mb-1">Email Address</label>
                    <input type="email" class="form-control form-control-user" id="email"
                        placeholder="you@example.com" name="email" autocomplete="username"
                        value="{{ old('email') }}" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-2" />
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block btn-lg" style="font-weight: 600;">
                    Send Reset Link
                </button>
            </form>

            <hr class="my-4">

            <div class="text-center mb-3">
                <a class="small text-decoration-none" href="{{ route('register') }}">Create an Account!</a>
            </div>
            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('login') }}">Already have an account? Login!</a>
            </div>
        </div>
    </div>
</div>
@endsection