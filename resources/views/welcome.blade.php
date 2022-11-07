@extends('layouts.app')

@section('content')
<div class="welcome">
    <div class="welcome-wrap">
        <a href="{{ route('user.login') }}" class="welcome-menu">ログイン</a>
        <a href="{{ route('user.register') }}" class="welcome-menu">会員登録</a>
    </div>
</div>
@endsection
