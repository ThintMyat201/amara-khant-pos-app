<x-guest-layout>
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-4 p-sm-5">
            <div class="text-center mb-4">
                <h2 class="h4 mb-1" style="font-weight: 700; color: #111827;">Reset Password</h2>
            </div>

            <form class="user" method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="form-group mb-3">
                    <label for="email" class="small text-muted mb-1">Email Address</label>
                    <input type="email" class="form-control form-control-user" id="email" name="email"
                        value="{{ old('email', $request->email) }}" required autofocus
                        placeholder="you@example.com" autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-2" />
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="small text-muted mb-1">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-user" id="password" name="password"
                            required placeholder="Enter new password" autocomplete="new-password">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-color: #dbdbdb;">
                                <i class="fas fa-eye-slash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="text-danger small mt-2" />
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation" class="small text-muted mb-1">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-user" id="password_confirmation"
                            name="password_confirmation" required placeholder="Confirm new password" autocomplete="new-password">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm"
                                style="border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-color: #dbdbdb;">
                                <i class="fas fa-eye-slash" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-2" />
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block btn-lg" style="font-weight: 600;">
                    Reset Password
                </button>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <a class="small text-decoration-none" href="{{ route('login') }}">Back to Login</a>
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
</x-guest-layout>
