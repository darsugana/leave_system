@extends('layout')

@section('content')
    <form action="{{ action('Auth\AuthController@postLogin') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="email">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div class="form-group text-center">
            <button class="btn btn-default">Login</button>
        </div>
    </form>
@append
