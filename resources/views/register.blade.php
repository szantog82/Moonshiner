@extends('layouts.main_layout')

@section('content')
<div class="container">
	<h3>Register new user</h3>
@if(isset($error_message))
	<h4 style="color: red">{{$error_message}}</h4>
@endif
    <form method="POST" action="{{route('register.store.user')}}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection