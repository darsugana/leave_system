@extends('layout')

@section('content')
    <form action="{{ route('users.store') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <label>Email</label>
            @include('components.error_message', ['field' => 'email'])
            <input class="form-control" type="text" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>Password</label>
            @include('components.error_message', ['field' => 'password'])
            <input class="form-control" type="password" name="password">
        </div>

        <div class="form-group">
            <label>Full Name</label>
            @include('components.error_message', ['field' => 'name'])
            <input class="form-control" type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                Is Admin?
            </label>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
@append
