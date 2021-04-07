<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        $params = $request->only('email', 'password');
    
        $username = $params['email'];
        $password = $params['password'];
    
        if(Auth::attempt(['email' => $username, 'password' => $password])){
            return Auth::user()->createToken('users', []);
        }
    
        return response()->json(['error' => 'Invalid username or Password']);
    }
}
