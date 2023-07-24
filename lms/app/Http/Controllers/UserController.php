<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login_page()
    {
        if(Session('username')){
            return redirect('/');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $password = $request->password;

        $user = User::where('username', $username)->first();

        if($user){
            if(Hash::check($password, $user->password)){
                Session::put(['user_id' => $user->id, 'username' => $username, 'name' => $user->name]);
                return redirect('/');
            }
            else{
                return redirect('login')->withInput()->withErrors(['password' => ['password is wrong']]);
            }
        }
        else{
            return redirect('login')->withInput()->withErrors(['username' => ['Invalid username']]);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }
}
