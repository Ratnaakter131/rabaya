<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Notifications\EmailVerifyNotifycation;
use Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerRegisterController extends Controller
{
    function register_login(){
        return view('frontend.customer_register');
    }
    function register_store(Request $request){
        CustomerLogin::insert([
           'name'=>$request->name,
           'email'=>$request->email,
           'password'=>bcrypt($request->password),
           'created_at'=>Carbon::now(),
        ]);
        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $delete_old = CustomerEmailVerify::where('customer_id', $customer->id)->delete();

        $email_info = CustomerEmailVerify::create([
            'customer_id' => $customer->id,
            'token' => uniqid(),
            'created_at' => Carbon::now(),
        ]);
        Notification::send($customer, new EmailVerifyNotifycation($email_info));

        return back();
    }
}
