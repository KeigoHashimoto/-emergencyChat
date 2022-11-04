@extends('layouts.app')

@section('content')
<div class="user-show">
    <h1>情報の確認 {{ link_to_route('user.edit','編集') }}</h1>
    <h3 class="user-show-contents">{{ $user->name }}</h3>
    <div class="user-show-contents">自分のID：{{ $user->user_id_number }}<br>
    <small>このIDで検索されます。友達になりたい人にこのIDを伝えてください。</small></div>
    <p class="user-show-contents">メールアドレス：{{ $user->email }}</p>
</div>
@endsection
