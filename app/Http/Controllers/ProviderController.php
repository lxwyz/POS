<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ProviderController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();

    }

    public function callback($provider) {
        $signUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'name' => $signUser->name,
            'nickname' => $signUser->nickname,
            'email' => $signUser->email,
            'provider_token' => $signUser->token,
            'provider_id' => $signUser->id,
            'provider' => $provider
        ]);
        Auth::login($user);

        return redirect('dashboard');
    }


}
