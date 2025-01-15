<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider) {

            $socialUser = Socialite::driver($provider)->user();
            // Handle the authenticated user data
            $user = User::updateOrCreate([
                'provider' => $provider,
                'provider_id' => $socialUser->id
            ],[
                'name' => $socialUser->name,
                'nickname' =>$socialUser->nickname,
                'email' => $socialUser->email,
                'provider_token' =>$socialUser->token,

            ]);
            Auth::login($user);

            return redirect('dashboard');

    }
}
