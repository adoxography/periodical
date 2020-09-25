<?php

namespace App\Http\Controllers;

use App\SocialAccountService;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function callback(SocialAccountService $accountService, string $provider): RedirectResponse
    {
        try {
            $social = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            abort(404);
        }

        $user = $accountService->findOrCreate($social, $provider);
        Auth::login($user, true);
        return redirect('/posts');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return back();
    }
}
