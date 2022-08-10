<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    function customer_logout(){
        Auth::guard('customerlogin')->logout();
        return redirect()->route('customer.register.login');
    }
}
