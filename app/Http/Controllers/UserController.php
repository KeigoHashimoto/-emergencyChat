<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\hankaku;
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
            'user_id_number' => ['required','min:6','max:20','unique:users,user_id_number',new hankaku],
        ],[
            'user_id_number.unique' => 'このIDは使用されています。別のIDをご使用ください。',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_id_number' => $request->user_id_number,
            'password' => Hash::make($request->password),
        ]);
        return redirect('/user')->with('success','会員登録完了！ログインしてください！');
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
    public function show(){
        $user=Auth::user();
        return view('users.show',compact('user'));
    }
    public function edit(){
        return view('users.edit');
    }
    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'user_id_number' => ['required','min:6','max:20','unique:users,user_id_number',new hankaku],
        ],[
            'user_id_number.unique' => 'このIDは使用されています。別のIDをご使用ください。',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_id_number' => $request->user_id_number,
        ]);
        return redirect('/user');
    }
    public function users(Request $request){
        $users = User::get();
        $keyword=$request->input('keyword');
        $query = User::query();
        if($keyword){
            $query->where('user_id_number',$keyword);
        }
        $users=$query->get();
        $followings=Auth::user()->followings()->get();
        $followers=Auth::user()->followers()->get();
        return view('users.users',compact('users','keyword','followings','followers'));
    }
    public function logout(){
        Auth::logout();
        return redirect('/user');
    }
    public function Follow($id){
        Auth::user()->follow($id);
        return redirect()->back();
    }
    public function unFollow($id){
        Auth::user()->unfollow($id);
        return redirect()->back();
    }
}
