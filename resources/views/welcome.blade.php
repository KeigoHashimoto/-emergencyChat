@extends('layouts.app')

@section('content')
<div class="welcome">
    <a href="{{ route('user.login') }}">ログイン</a>
    <a href="{{ route('user.register') }}">会員登録</a>
</div>
@endsection
