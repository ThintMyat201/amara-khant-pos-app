@extends('layouts.guest')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-4 p-sm-5">
            <div class="text-center mb-4">
                <h2 class="h4 mb-1" style="font-weight: 700; color: #111827;">Sign in</h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form class="user" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="email" class="small text-muted mb-1">Email or Username</label>
                    <input
                        type="email"
                        class="form-control form-control-user"
                        id="email"
                        aria-describedby="emailHelp"
                        placeholder="you@example.com"
                        name="email"
                        autofocus
                        value="{{ old('email') }}"
                    >
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-2" />
                </div>

                <div class="form-group mb-2">
                    <label for="password" class="small text-muted mb-1">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control form-control-user"
                            id="password"
                            placeholder="Your password"
                            name="password"
                            autocomplete="current-password"
                        >
                        <div class="input-group-append">
                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="togglePassword"
                                style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-color: #dbdbdb;"
                            >
                                <i class="fas fa-eye-slash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-danger small mt-2" />
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check mb-0">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="remember"
                            name="remember"
                            value="{{ old('remember') ? 'checked' : '' }}"
                        >
                        <label class="form-check-label small text-muted" for="remember">
                            Remember Me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-user btn-block btn-lg"
                    style="font-weight: 600;"
                >
                    Login
                </button>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('register.request') }}">
                    Request Account Registration
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const password = document.getElementById('password');
        const icon = this.querySelector('i');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>
@endsection