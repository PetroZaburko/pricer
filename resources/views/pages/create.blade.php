@extends('layout')
@section('content')
    <div class="text-center">
        <h4>
            Add new category
        </h4>
    </div>
    @include ('pages.errors')
    {{Form::open(['route' => 'categories.store'])}}
        <div class="form-row">
            <div class="form-group col-10">
                <input type="text" placeholder="New category" autofocus class="form-control" name="title" >
            </div>
            <div class="form-group col-2">
                <button type="submit" class="btn btn-primary btn-block" >
                    <i class="fas fa-plus"></i>
                    Add
                </button>
            </div>
        </div>
    {{ Form::close() }}
@endsection
