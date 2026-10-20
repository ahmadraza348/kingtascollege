@extends('backend.layouts.layout')
@section('title', 'Change Password - King TAS Admin')
@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Change Password</h4>
                <h6>Update the password you use to sign in to the admin panel.</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.password.update') }}" method="POST" autocomplete="off">
                            @csrf

                            <div class="form-group mb-3">
                                <label class="mb-1">Current password</label>
                                <div class="position-relative">
                                    <input type="password" name="current_password" class="form-control pw-field" required
                                        autocomplete="current-password">
                                    <span class="fas fa-eye-slash pw-toggle" role="button" tabindex="0" aria-label="Show or hide password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;"></span>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="mb-1">New password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control pw-field" required minlength="8"
                                        autocomplete="new-password">
                                    <span class="fas fa-eye-slash pw-toggle" role="button" tabindex="0" aria-label="Show or hide password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;"></span>
                                </div>
                                <div class="form-text">At least 8 characters, with letters and numbers.</div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="mb-1">Confirm new password</label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation" class="form-control pw-field" required
                                        minlength="8" autocomplete="new-password">
                                    <span class="fas fa-eye-slash pw-toggle" role="button" tabindex="0" aria-label="Show or hide password" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;"></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit me-2">Update Password</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">Cancel</a>
                        </form>
                    </div>
                </div>
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
