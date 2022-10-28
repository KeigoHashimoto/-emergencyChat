@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row col-md-5">
        @if(Session::has('success'))
            <p class="alert alert-success>{{ Session::get('success') }}</p>
        @endif
        <h1>User Login</h1>
        <form action='{{ route('user.doLogin') }}' method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
                <p class="text-danger">@error('email')
                    {{ $message }}
                @enderror</p>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <p class="text-danger">@error('password')
                    {{ $message }}
                @enderror</p>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>        
    </div>
</div>
@endsection