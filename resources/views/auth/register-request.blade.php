@extends('layouts.guest')
@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-3 p-sm-4 p-md-5">
            <div class="mb-3 mb-md-4 text-center text-md-start">
                <h1 class="h4 text-gray-900 mb-1 fw-bold">Request Account Registration</h1>
                <p class="mb-0 text-muted small">
                    Fill in your details and we’ll notify an admin to approve your access.
                </p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register.request.store') }}">
                @csrf

                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="name" class="small text-muted mb-1">Full Name</label>
                    <input
                        type="text"
                        class="form-control form-control-user"
                        id="name"
                        placeholder="John Doe"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >
                    <x-input-error :messages="$errors->get('name')" class="text-danger small mt-2" />
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email" class="small text-muted mb-1">Email Address</label>
                    <input
                        type="email"
                        class="form-control form-control-user"
                        id="email"
                        placeholder="you@example.com"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-2" />
                </div>

                <!-- Phone -->
                <div class="form-group mb-3">
                    <label for="phone" class="small text-muted mb-1">Phone Number (Optional)</label>
                    <input
                        type="text"
                        class="form-control form-control-user"
                        id="phone"
                        placeholder="+95 ..."
                        name="phone"
                        value="{{ old('phone') }}"
                    >
                    <x-input-error :messages="$errors->get('phone')" class="text-danger small mt-2" />
                </div>

                <!-- Address -->
                <div class="form-group mb-3">
                    <label for="address" class="small text-muted mb-1">Address (Optional)</label>
                    <input
                        type="text"
                        class="form-control form-control-user"
                        id="address"
                        placeholder="Store or branch address"
                        name="address"
                        value="{{ old('address') }}"
                    >
                    <x-input-error :messages="$errors->get('address')" class="text-danger small mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group mb-3">
                    <label for="password" class="small text-muted mb-1">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control form-control-user"
                            id="password"
                            placeholder="Create a password"
                            name="password"
                            required
                        >
                        <div class="input-group-append">
                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="togglePassword"
                                style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem;"
                            >
                                <i class="fas fa-eye-slash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-danger small mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group mb-4">
                    <label for="password_confirmation" class="small text-muted mb-1">Confirm Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            class="form-control form-control-user"
                            id="password_confirmation"
                            placeholder="Repeat your password"
                            name="password_confirmation"
                            required
                        >
                        <div class="input-group-append">
                            <button
                                class="btn btn-outline-secondary"
                                type="button"
                                id="togglePasswordConfirm"
                                style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem;"
                            >
                                <i class="fas fa-eye-slash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-2" />
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block btn-lg">
                    Submit Registration Request
                </button>
            </form>

            <hr class="my-3 my-md-4">

            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('login') }}">
                    Already have an account? Login!
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

    document.getElementById('togglePasswordConfirm').addEventListener('click', function () {
        const password = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
