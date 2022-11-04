@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row col-md-5">
        <h1>User Edit</h1>
        {{ Form::model(Auth::user(),['route'=>'user.update','method'=>'put']) }}
            <div class="form-group">
                {{ Form::label('name','Name',['class'=>'form-label']) }}
                {{ Form::text('name',null,['class'=>'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('email','Email',['class'=>'form-label']) }}
                {{ Form::email('email',null,['class'=>'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('user_id_number','ID',['class'=>'form-label']) }}
                {{ Form::text('user_id_number',null,['class'=>'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::submit('登録',['class'=>'btn btn-primary mt-3']) }}

            </div>
        {{ Form::close() }}      
    </div>
</div>
@endsection