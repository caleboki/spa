@extends('layouts.app')

@section('title') Create User @endsection

@section('content')

<div class='col-lg-4 col-lg-offset-4'>

    @if ($errors->has())
        @foreach ($errors->all() as $error)
            <div class='bg-danger alert'>{{ $error }}</div>
        @endforeach
    @endif

    <h1><i class='fa fa-user-plus'></i> Add User</h1>

    <form action="{{ route('add.user') }}" method="post">
        <div class="form-group {{ $errors->has('name') ? 'has-error' :''}}" >
            <label for="name">Name</label>
            <input class="form-control" type="text" name="name" id = "name" value="{{ Request::old('name')}}">
        </div>

        <div class="form-group {{ $errors->has('email') ? 'has-error' :''}}">
            <label for="email">Email</label>
            <input class="form-control" type="text" name="email" id="email" value="{{ Request::old('email')}}">
        </div>

        <div class='form-group'>
            @foreach ($roles as $role)
            <input type="checkbox" name='roles[]' value={{ $role->id }}> {{ ucfirst($role->name) }} <br>
            
            @endforeach
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' :''}}">
            <label for="password">Password</label>
            <input class="form-control" type="password" name="password" id "password" value="{{ Request::old('password')}}">
        </div>

        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' :''}}">
            <label for="password_confirmation">Confirm Password</label>
            <input class="form-control" type="password" name="password_confirmation" id "password_confirmation" value="{{ Request::old('password_confirmation')}}">
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
        <input type="hidden" name="_token" value="{{Session::token()}}">
        </form>

    

</div>

@stop