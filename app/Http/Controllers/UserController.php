<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;

class UserController extends Controller
{
    public function register(){
        return view('auth.register');
    }
    public function login(){
        return view('auth.login');
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|max:15',
            'password_confirm' => 'required|same:password',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('user.login')->with('success','会員登録完了！ログインしてください！');
    }

    public function doLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|max:15',
        ]);
        $roles = $request->only(['email','password']);  
        if(Auth::attempt($roles)){
            return redirect()->route('user.home')->with('success','ログインしました！');
        }else{
            return redirect()->back()->with('error','メールアドレスかパスワードが間違えています。');
        }
    }
    public function index(){
        return view('users.home');
    }
    public function logout(){
        Auth::logout();
        return redirect('/user');
    }
}
