@extends('layout')
@section('content')
    <div class="text-center">
        <h4>
            Edit user "{{$user->name}}"
        </h4>
    </div>
    @include ('pages.errors')
    {{Form::open(['action' => ['UsersController@update',$user->id], 'method'=>'put'])}}
    <div class="form-row">
        <div class="form-group col-10">
            <input type="text" class="form-control" name="name" value="{{$user->name}}">
        </div>
        <div class="form-group col-2">
            <button type="submit" class="btn btn-success btn-block">
                <i class="far fa-save"></i>
                Save
            </button>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-10">
            <input type="email" class="form-control" name="email" value="{{$user->email}}">
        </div>
        <div class="form-group col-2">
            <button type="button" class="btn btn-primary btn-block" onclick="history.back(-1)">
                <i class="fas fa-arrow-left"></i>
                Back
            </button>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-10">
            <input type="password" class="form-control" name="old_password" placeholder="Old password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-10">
            <input type="password" class="form-control" name="password" placeholder="New password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-10">
            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
        </div>
    </div>
    {{Form::close()}}
@endsection
