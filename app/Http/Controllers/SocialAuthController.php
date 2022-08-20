<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\UserSocial;


class SocialAuthController extends Controller
{

    public function google_redirect() {

        return [
            'redirect_uri' => Socialite::with('google')
                                ->stateless()
                                ->redirect()
                                ->getTargetUrl()
        ];
    }

    public function google_callback() {

        $user = Socialite::with('google')->stateless()->user();

        $data = [
            'user_social_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->avatar,
            'access_token' => $user->token,
            'refresh_token' => $user->refreshToken 
        ];

        $user = UserSocial::updateOrCreate(
            ['user_social_id' => $user->id],
            $data
        );

        $token = auth()->login($user);

        return [ 'token' => $token ];  
    }

}
