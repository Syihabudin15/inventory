<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(){
        if(Auth::check()){
            return redirect('/dashboard');
        }else{
            return view("LoginView");
        }
    }
}
