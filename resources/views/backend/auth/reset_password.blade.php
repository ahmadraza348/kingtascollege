@extends('backend.auth.layouts.layout')
@section('title', 'Reset Password - King TAS Admin')
@section('content')

<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset ">
                    <div class="login-logo">
                        <img src="{{ asset('backend/assets/img/logo.png') }}" alt="img">
                    </div>
                    <div class="login-userheading">
                        <h3>Reset Password</h3>
                        <h4>Choose a new password for <strong>{{ $email }}</strong>.</h4>
                    </div>
                    <form action="{{ route('reset.password.post', ['token' => $token]) }}" method="POST" autocomplete="off">
                        @csrf

                        <div class="form-login">
                            <label>New password</label>
                            <div class="position-relative">
                                <input type="password" required name="password" class="form-control pw-field"
                                    placeholder="At least 8 characters, letters and numbers" minlength="8" autocomplete="new-password">
                                <span class="fas fa-eye-slash pw-toggle" role="button" tabindex="0" aria-label="Show or hide password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;"></span>
                            </div>
                            <div class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-login">
                            <label>Confirm new password</label>
                            <div class="position-relative">
                                <input type="password" required name="password_confirmation" class="form-control pw-field"
                                    placeholder="Re-enter the new password" minlength="8" autocomplete="new-password">
                                <span class="fas fa-eye-slash pw-toggle" role="button" tabindex="0" aria-label="Show or hide password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;"></span>
                            </div>
                        </div>

                        <div class="form-login">
                            <button class="btn btn-login" type="submit">Reset Password</button>
                        </div>
                        <div class="form-login text-center">
                            <a href="{{ route('admin.login') }}" class="hover-a">&larr; Back to Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login-img">
                <img src="{{ asset('backend/assets/img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.pw-toggle').forEach(function (icon) {
        function flip() {
            var input = icon.parentElement.querySelector('.pw-field');
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', show);
            icon.classList.toggle('fa-eye-slash', !show);
        }
        icon.addEventListener('click', flip);
        icon.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); flip(); } });
    });
});
</script>
