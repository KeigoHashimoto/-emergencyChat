@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        @if(Session::has('success'))
            <p class="alert alert-success">{{ session::get('success') }}</p>
        @endif
        <example-component></example-component>
    </div>
</div>

@endsection