@extends('backend.auth.layouts.layout')

@section('title', 'Admin Login | King TAS College')

@section('content')
<style>
    body.account-page {
        min-height: 100vh !important;
        height: auto !important;
        margin: 0;
        overflow-x: hidden;
        background: #f2f6fb !important;
    }

    .college-login-page {
        --college-navy: #12345a;
        --college-blue: #1f5f91;
        --college-teal: #168b86;
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        isolation: isolate;
        background:
            radial-gradient(circle at 12% 18%, rgba(22, 139, 134, .10), transparent 27%),
            radial-gradient(circle at 88% 82%, rgba(31, 95, 145, .11), transparent 30%),
            linear-gradient(135deg, #f8fbff 0%, #edf3f9 52%, #f7fafc 100%);
    }

    .college-login-page::before,
    .college-login-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        border: 1px solid rgba(18, 52, 90, .07);
        border-radius: 50%;
        pointer-events: none;
    }

    .college-login-page::before {
        width: 420px;
        height: 420px;
        top: -230px;
        right: -120px;
    }

  

    .college-login-shell {
        width: 100%;
        max-width: 460px;
        margin: auto;
    }

    .college-login-card {
        width: 100%;
        background: #fff;
        border: 1px solid #e5ebf2;
        border-radius: 20px;
        padding: 38px 42px 32px;
        box-shadow: 0 22px 65px rgba(18, 52, 90, .12);
    }

    .college-brand {
        text-align: center;
        margin-bottom: 15px;
    }

    .college-brand-mark {
        display: inline-flex;
        width: 68px;
        height: 68px;
        align-items: center;
        justify-content: center;
        color: #fff;
        border-radius: 18px;
        margin-bottom: 15px;
        background: linear-gradient(145deg, var(--college-navy), var(--college-teal));
        box-shadow: 0 9px 22px rgba(18, 52, 90, .20);
    }

    .college-brand-mark svg {
        width: 37px;
        height: 37px;
    }

    .college-brand h1 {
        color: var(--college-navy);
        font-size: 22px;
        line-height: 1.3;
        font-weight: 800;
        letter-spacing: -.45px;
        margin: 0;
    }

    .college-brand p {
        color: #718096;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 1.15px;
        text-transform: uppercase;
        margin: 7px 0 0;
    }

    .college-login-heading {
        text-align: center;
        margin-bottom: 27px;
    }

    .college-login-heading h2 {
        color: #1d2d40;
        font-size: 23px;
        line-height: 1.35;
        font-weight: 750;
        margin: 0 0 6px;
    }

    .college-login-heading p {
        color: #7b8795;
        font-size: 14px;
        margin: 0;
    }

    .college-login-form .form-login {
        margin-bottom: 19px;
    }

    .college-login-form label {
        display: block;
        color: #34465b;
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 8px;
    }

    .college-login-form .form-control,
    .college-login-form .pass-input {
        width: 100%;
        height: 50px;
        color: #26384b;
        background: #fbfcfe;
        border: 1px solid #dce4ed;
        border-radius: 10px;
        padding: 0 15px;
        font-size: 14px;
        box-shadow: none;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .college-login-form .form-control:focus,
    .college-login-form .pass-input:focus {
        border-color: var(--college-teal);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(22, 139, 134, .12);
        outline: none;
    }

    .college-login-form .form-addons,
    .college-login-form .pass-group {
        position: relative;
    }

    .college-login-form .form-addons .form-control {
        padding-right: 45px;
    }

    .college-login-form .form-addons > img {
        position: absolute;
        width: 18px;
        height: 18px;
        right: 15px;
        top: 16px;
        opacity: .55;
    }

    .college-login-form .pass-input {
        padding-right: 46px;
    }

    .college-login-form .toggle-password {
        position: absolute;
        top: 17px;
        right: 15px;
        color: #7b8795;
        cursor: pointer;
    }

    .college-login-form .text-danger {
        display: block;
        font-size: 12px;
        margin-top: 6px;
    }

    .college-login-form .forgot-row {
        display: flex;
        justify-content: flex-end;
        margin-top: -5px;
        margin-bottom: 22px;
    }

    .college-login-form .forgot-row a {
        color: var(--college-blue);
        font-size: 13px;
        font-weight: 650;
        text-decoration: none;
    }

    .college-login-form .forgot-row a:hover {
        color: var(--college-teal);
        text-decoration: underline;
    }

    .college-login-form .btn-login {
        width: 100%;
        min-height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 10px;
        color: #fff;
        background: linear-gradient(100deg, var(--college-navy), var(--college-blue) 58%, var(--college-teal));
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .2px;
        box-shadow: 0 8px 18px rgba(18, 52, 90, .18);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .college-login-form .btn-login:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 11px 22px rgba(18, 52, 90, .23);
    }

    .college-login-footer {
        color: #98a3af;
        font-size: 12px;
        text-align: center;
        margin-top: 25px;
    }

    @media (max-width: 575.98px) {
        .college-login-page {
            padding: 22px 14px;
        }

        .college-login-card {
            padding: 30px 23px 25px;
            border-radius: 16px;
        }

        .college-brand h1 {
            font-size: 19px;
        }

        .college-login-heading h2 {
            font-size: 21px;
        }
    }
</style>

<div class="college-login-page">
    <main class="college-login-shell">
        <section class="college-login-card" aria-labelledby="college-login-title">
            <header class="college-brand">
                <img src="{{ asset('frontend/assets/images/logo/logo.png') }}" alt="" style="width: 100px; height: 100px;">
               
            </header>

            <div class="college-login-heading">
                <h2 id="college-login-title">Admin Portal</h2>
                <p>Sign in to manage your college</p>
            </div>

            <form method="post" action="{{ route('admin.login.submit') }}" class="college-login-form">
                @csrf

                <div class="form-login">
                    <label for="email_username">Email or Username</label>
                    <div class="form-addons">
                        <input
                            type="text"
                            name="email_username"
                            id="email_username"
                            class="form-control"
                            value="{{ old('email_username') }}"
                            placeholder="Enter your email or username"
                            autocomplete="username"
                            required
                            autofocus
                        >
                        <img src="{{ asset('backend/assets/img/icons/mail.svg') }}" alt="">
                    </div>
                    @error('email_username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-login">
                    <label for="password">Password</label>
                    <div class="pass-group">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="pass-input"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >
                        <span class="fas toggle-password fa-eye-slash" aria-label="Toggle password visibility"></span>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="forgot-row">
                    <a href="#">Forgot Password?</a>
                </div>

                <div class="form-login mb-0">
                    <button class="btn btn-login" type="submit">Sign In to Admin Portal</button>
                </div>
            </form>

        </section>
    </main>
</div>
@endsection
