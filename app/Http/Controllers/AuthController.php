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

    public function handleLogin(Request $request){
        $validate = $request->validate([
            "username" => ['required', 'min:5'],
            "password" => ['required', 'min:5']
        ]);
        $cred = [
            "username" => $validate['username'],
            "password" => $validate['password']
        ];
        if(Auth::attempt($cred)){
            return redirect('/dashboard');
        }else{
            return redirect('/')->with(['error' => "Wrong username or password"]);
        }
    }

    public function handleLogout(){
        Auth::logout();
        return redirect('/');
    }
}
