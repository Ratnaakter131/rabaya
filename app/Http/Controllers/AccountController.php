<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Models\CustomerPassReset; 
use App\Models\Order;
use App\Notifications\passResetNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PDF;


class AccountController extends Controller
{
    function account(){
        $order_infos = Order::where('user_id', Auth::guard('customerlogin')->id())->get();
        return view('account',[
            'order_infos'=> $order_infos,
        ]);
    }

    function invoice_download($order_id){
         $data = [
            'order_id'=>$order_id,
         ];
        $pdf = PDF::loadView('invoice.invoice_download', $data);
        return $pdf->stream('class_one_invoice.pdf');
    }

    function pass_reset_req() {
      return view('pass_reset_req');
    }
    function pass_reset_store(Request $request){
       $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
       $delete_old = CustomerPassReset::where('customer_id', $customer->id)->delete();

       $pass_rest_info = CustomerPassReset::create([
          'customer_id'=>$customer->id,
          'token'=>uniqid(),
          'created_at'=>Carbon::now(),
       ]);
       Notification::send($customer, new passResetNotification($pass_rest_info));
    }
    function pass_reset_form($token){
        if(CustomerPassReset::where('token', $token)->exists()){
            return view('pass_reset_form', compact('token'));
        }
        else{
            abort(404);
        }
    }
    function pass_reset_update(Request $request){
       $customer = CustomerPassReset::where('token', $request->token)->firstOrFail();
       $customer_id = CustomerLogin::findOrFail($customer->customer_id);

       $customer_id->update([
        'password'=>Hash::make($request->password),
       ]);
       CustomerPassReset::where('customer_id', $customer->customer_id)->delete();
       return redirect()->route('customer.register.login')->with('success', 'Password Reset Success!');
    }

    function customeremail_verify($token){
        $customer = CustomerEmailVerify::where('token', $token)->firstOrFail();
        $customer_id = CustomerLogin::findOrFail($customer->customer_id);

        $customer_id->update([
            'email_verified_at' =>Carbon::now(),
        ]);
        CustomerEmailVerify::where('customer_id', $customer->customer_id)->delete();
        return redirect()->route('customer.register.login')->with('success', 'Your Email has been verified!');
    }
}
