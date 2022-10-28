@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row col-md-5">
        @if(Session::has('error'))
            <p class="alert alert-error">{{ Session::get('error') }}</p>
        @endif
        <h1>User Registration</h1>
        <form action='{{ route('user.store') }}' method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="name" class="form-control" id="name" name="name">
                <p class="text-danger">@error('name')
                    {{ $message }}
                @enderror</p>
            </div>
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
            <div class="mb-3">
                <label for="password_confirm" class="form-label">Confirm</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                <p class="text-danger">@error('password_confirm')
                    {{ $message }}
                @enderror</p>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>        
    </div>
</div>
@endsection