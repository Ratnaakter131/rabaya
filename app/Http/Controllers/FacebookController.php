<?php

namespace App\Http\Controllers;

use App\Models\CustomerLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    function facebook_redirect() {
        return Socialite::driver('facebook')->redirect();
    }
    function facebook_callback() {
        $user = Socialite::driver('facebook')->user();
        if (CustomerLogin::where('email', $user->getEmail())->exists()) {
            if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'ratnaakterrabaya@gmail.com'])) {
                return redirect('/');
            }
        } else {
            CustomerLogin::insert([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt('ratnaakterrabaya@gmail.com'),
                'created_at' => Carbon::now(),
            ]);

            if (Auth::guard('customerlogin')->attempt(['email' => $user->getEmail(), 'password' => 'ratnaakterrabaya@gmail.com'])) {
                return redirect('/');
            }
        }
    }
}
