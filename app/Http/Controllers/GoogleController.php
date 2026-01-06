<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class GoogleController extends Controller
{
    public function redirectToGoogle($role = 'user')
{
    session(['register_role' => $role]);
    return Socialite::driver('google')->redirect();
}

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                    ]);
                }

                Auth::login($user, true);
                return $this->redirectBasedOnRole($user->role);
            }

            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'role' => session('register_role', 'user'),
                'email_verified_at' => now(),
                'password' => null,
            ]);

            session()->forget('register_role');

            Auth::login($user, true);
            return $this->redirectBasedOnRole($user->role);

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login Google gagal.');
        }
    }

    protected function redirectBasedOnRole($role)
    {
        return match ($role) {
            'admin'   => redirect('/admin/dashboard'),
            'pemilik' => redirect('/pemilik/dashboard'),
            default   => redirect('/dashboard'),
        };
    }
}
