<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister(){
        return view('register');
    }

    public function register(Request $request){
        $login    = $request->login;
        $email    = $request->email;
        $password = $request->password;
        $role     = $request->role ?? 'student';

        $exists = User::where('login', $login)
            ->orWhere('email', $email)
            ->first();

        if ($exists) {
            return back()->with('error', 'Login or email already taken.')->withInput();
        }

        $user = User::create([
            'login'    => $login,
            'email'    => $email,
            'password' => $password,
        ]);

        $user->assignRole($role);

        return redirect('/dashboard')->with('success', 'Account created!');
    }

    public function showLogin(){
        return view('login');
    }

    public function login(Request $request){
        $login    = $request->login;
        $password = $request->password;

        $user = User::where('login', $login)->where('password', $password)->first();

        if ($user) {
            session([
                'user_id'    => $user->id,
                'user_login' => $user->login,
                'user_role'  => $user->getRoleNames()->first(),
            ]);

            return redirect('/dashboard');
        }

        return back()->with('error', 'Wrong login or password')->withInput();
    }

    public function logout(){
        session()->flush();
        return redirect('/');
    }
}
