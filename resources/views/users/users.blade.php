@extends('layouts.app')

@section('content')
<div class="tags-container">
    <div id="tags">
        <div class="tags">
            <ul>
                <li @click="tags = 'tag0'">Sarch</li>
                <li @click="tags = 'tag1'">Followings</li>
                <li @click="tags = 'tag2'">Followers</li>
            </ul>
        </div>
        <div v-show="tags === 'tag0'">
            <div class="form-wrap">
                {{-- 検索フォーム --}}
                {{ Form::open(['route'=>'user.users','method'=>'get','class'=>'form']) }}
                    {{ Form::text('keyword',null,['class'=>'form-control']) }}
                    {{ Form::submit('検索',['class'=>'btn btn-primary']) }}
                {{ Form::close() }}
                <small>ユーザーIDを入力してフォローしてください。<br>
                相互フォローになるとやり取りができるようになります。<br>
                </small>
            </div>
            <div class="users">
                @foreach($users as $user)
                    {{-- ユーザ一覧 --}}
                    @if($keyword != null)
                        <div class="user">
                            <p>{{ $user->name }}</p>
                            @if(Auth::id() != $user->id)
                                @if(!Auth::user()->is_followed($user->id))
                                    {{ Form::open(['route' => ['user.follow',$user->id]]) }}
                                        {{ Form::submit('Follow',['class'=>'follow-btn']) }}
                                    {{ Form::close() }}
                                @else
                                    {{ Form::open(['route'=>['user.unfollow',$user->id],'method' => 'delete']) }}
                                        {{ Form::submit('UnFollow',['class'=>'unfollow-btn']) }}
                                    {{ Form::close() }}
                                @endif
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="followings" v-show="tags === 'tag1'">
            <h1>フォロー中のユーザー</h1>
            @if($followings->isEmpty())
                <p>誰もフォローしていません</p>
            @else
                <div>
                    @foreach($followings as $follow)
                        <div class="user">
                            <p>{{ $follow->name }}</p>
                            @if(Auth::id() != $follow->id)
                                @if(!Auth::user()->is_followed($follow->id))
                                    {{ Form::open(['route' => ['user.follow',$follow->id]]) }}
                                        {{ Form::submit('Follow',['class'=>'follow-btn']) }}
                                    {{ Form::close() }}
                                @else
                                    {{ Form::open(['route'=>['user.unfollow',$follow->id],'method' => 'delete']) }}
                                        {{ Form::submit('UnFollow',['class'=>'unfollow-btn']) }}
                                    {{ Form::close() }}
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="followers" v-show="tags === 'tag2'">
            <h1>フォロワー</h1>
            @if($followers->isEmpty())
                <p>誰にもフォローされていません</p>
            @else
                <div class="users">
                    @foreach($followers as $follower)
                        <div class="user">
                            <p>{{ $follower->name }}</p>
                            @if(Auth::id() != $follower->id)
                                @if(!Auth::user()->is_followed($follower->id))
                                    {{ Form::open(['route' => ['user.follow',$follower->id]]) }}
                                        {{ Form::submit('Follow',['class'=>'follow-btn']) }}
                                    {{ Form::close() }}
                                @else
                                    {{ Form::open(['route'=>['user.unfollow',$follower->id],'method' => 'delete']) }}
                                        {{ Form::submit('UnFollow',['class'=>'unfollow-btn']) }}
                                    {{ Form::close() }}
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection