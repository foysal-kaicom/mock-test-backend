<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }

    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
           
            $user=Auth::user();

            if($user->status == 'frozen')
            {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account has been frozen.');
            }
            $user->update([
                'last_login'=>now()
            ]);
            session()->flash('success', 'Login successful!');
            return redirect()->route('user.dashboard');
        }
    
        session()->flash('error', 'Invalid Credentials.');
        return redirect()->back();
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
    
}
