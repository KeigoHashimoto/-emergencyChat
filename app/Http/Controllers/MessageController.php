<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Events\CreatedMessage;
use App\Events\PostedMessage;
use App\Mail\MessagePostMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class MessageController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'content'=>'required|max:1000',
        ]);

        $user=Auth::user();

        $message=new Message;
        $message->content = $request->content;
        $message->user_id = $request->user_id;
        $message->latitude = $request->latitude;
        $message->longitude = $request->longitude;
        $message->save();

        //Pusherに通知を送るイベント
        event(new CreatedMessage($message));
        $users=$user->followers()->get();
        event(new PostedMessage($users,$user));
        
    }
    public function index(){
        return Auth::user()->feed()->orderBy('created_at','desc')->get();
    }
    public function users(){
        return User::get();
    }
    public function authUser(){
        return Auth::id();
    }
}
