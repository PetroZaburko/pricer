@extends('layout')
@section('content')
    <div class="text-center">
        <h4>
            Edit category "{{$category->title}}"
        </h4>
    </div>
    @include ('pages.errors')
        {{Form::open(['route' => ['categories.update',$category->id], 'method'=>'put'])}}
        <div class="form-row">
            <div class="form-group col-10">
                <input type="text" class="form-control" name="title" value="{{$category->title}}">
            </div>
            <div class="form-group col-2">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="far fa-save"></i>
                    Save
                </button>
            </div>
        </div>
        {{Form::close()}}
@endsection
