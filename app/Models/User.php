<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Message;
use App\Models\User;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'user_id_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function followings(){
        return $this->belongsToMany(User::class,'user_follow','user_id','follow_id');
    }
    public function followers(){
        return $this->belongsToMany(User::class,'user_follow','follow_id','user_id');
    }
    public function follow($userId){
        $exist = $this->is_followed($userId);
        $me = $this->id === $userId;
        if($exist || $me){
            return false;
        }else{
            $this->followings()->attach($userId);
            return true;
        };
    }
    public function unfollow($userId){
        $exist = $this->is_followed($userId);
        $me = $this->id === $userId;
        if($exist && !$me){
            $this->followings()->detach($userId);
            return true;
        }else{
            return false;
        }
    }
    public function is_followed($userId){
        return $this->followings()->where('follow_id',$userId)->exists();
    }
    public function feed(){
        // フォローしている人のユーザーidを抽出して配列に入れる
        $followUserIds = $this->followings()->pluck('users.id')->toArray();

        $follow_each = $this->followers()->whereIn('user_id',$followUserIds)->pluck('users.id')->toArray();
        // 自分も配列に入れる
        $follow_each[]=$this->id;
        
        // メッセージ+ユーザーからuser_idと$userIdが同じものを探す
        return Message::with('user')->whereIn('user_id',$follow_each);
    }
}
