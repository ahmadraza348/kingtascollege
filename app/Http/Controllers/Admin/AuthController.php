<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetPasswordMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Throwable;

class AuthController extends Controller
{
    /** Minutes a password-reset link stays valid. */
    private const RESET_LINK_LIFETIME = 60;

    public function login()
    {
        return check_admin_auth('backend.auth.login');
    }

    public function login_submit(Request $request)
    {
        $request->validate([
            'email_username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email_username', 'password');
        $field = filter_var($credentials['email_username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $authAttempt = Auth::guard('admin')->attempt([
            $field => $credentials['email_username'],
            'password' => $credentials['password'],
            'status' => '1',
        ]);

        if ($authAttempt) {
            $request->session()->regenerate();
            toastr()->success('Admin Login successfully.');

            return redirect()->intended(route('admin.dashboard'));
        }

        toastr()->error('Invalid credentials or account is blocked.');

        return redirect()->back()->withInput($request->only('email_username'));
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toastr()->success('Admin Logout Successfully');

        return redirect()->route('admin.login');
    }

    /* ------------------------------------------------------------------
     |  Forgot password
     | ------------------------------------------------------------------ */

    public function forgetpass()
    {
        return check_admin_auth('backend.auth.forget_password');
    }

    public function submitforgetpass(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($request->email));
        $admin = Admin::whereRaw('LOWER(email) = ?', [$email])->where('status', '1')->first();

        // Same answer whether or not the address exists, so the form cannot be used
        // to discover which e-mail addresses belong to admins.
        $genericMessage = 'If that e-mail belongs to an admin account, a password reset link has been sent.';

        if (! $admin) {
            toastr()->success($genericMessage);

            return redirect()->back();
        }

        // Only the hash of the token is stored; the raw token only exists in the e-mailed link.
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $admin->email],
            ['token' => hash('sha256', $token), 'created_at' => Carbon::now()]
        );

        try {
            Mail::to($admin->email)->send(new AdminResetPasswordMail($admin, $token, self::RESET_LINK_LIFETIME));
        } catch (Throwable $e) {
            report($e);
            DB::table('password_reset_tokens')->where('email', $admin->email)->delete();
            toastr()->error('We could not send the e-mail right now. Please check the mail settings and try again.');

            return redirect()->back();
        }

        toastr()->success($genericMessage);

        return redirect()->back();
    }

    public function show_reset_pass_form($token)
    {
        $record = $this->findValidResetRecord($token);

        if (! $record) {
            toastr()->error('This password reset link has expired or is invalid. Please request a new one.');

            return redirect()->route('admin.forgetpass');
        }

        return view('backend.auth.reset_password', [
            'token' => $token,
            'email' => $record->email,
        ]);
    }

    public function submit_reset_pass_form(Request $request, $token)
    {
        $request->validate([
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $record = $this->findValidResetRecord($token);

        if (! $record) {
            toastr()->error('This password reset link has expired or is invalid. Please request a new one.');

            return redirect()->route('admin.forgetpass');
        }

        $admin = Admin::where('email', $record->email)->where('status', '1')->first();

        if (! $admin) {
            DB::table('password_reset_tokens')->where('email', $record->email)->delete();
            toastr()->error('This account is not available.');

            return redirect()->route('admin.login');
        }

        // The model's "hashed" cast hashes the value on save.
        $admin->password = $request->password;
        $admin->setRememberToken(Str::random(60));
        $admin->save();

        DB::table('password_reset_tokens')->where('email', $record->email)->delete();

        toastr()->success('Your password has been updated. Please sign in with the new password.');

        return redirect()->route('admin.login');
    }

    /* ------------------------------------------------------------------
     |  Change password (signed-in admin)
     | ------------------------------------------------------------------ */

    public function changePasswordForm()
    {
        return view('backend.auth.change_password');
    }

    public function changePasswordSubmit(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', 'different:current_password', Password::min(8)->letters()->numbers()],
        ], [
            'password.different' => 'The new password must be different from your current password.',
            'password.confirmed' => 'The new password and its confirmation do not match.',
        ], [
            'current_password' => 'current password',
            'password' => 'new password',
        ]);

        if (! Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $admin->password = $request->password;
        $admin->setRememberToken(Str::random(60));
        $admin->save();

        // Keep this session signed in, but rotate the session id after a credential change.
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();

        // Any pending reset link for this account is no longer needed.
        DB::table('password_reset_tokens')->where('email', $admin->email)->delete();

        toastr()->success('Your password has been changed successfully.');

        return redirect()->route('admin.password.change');
    }

    /* ------------------------------------------------------------------ */

    private function findValidResetRecord(string $token): ?object
    {
        $record = DB::table('password_reset_tokens')
            ->where('token', hash('sha256', $token))
            ->first();

        if (! $record || ! $record->created_at) {
            return null;
        }

        if (Carbon::parse($record->created_at)->addMinutes(self::RESET_LINK_LIFETIME)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $record->email)->delete();

            return null;
        }

        return $record;
    }
}
