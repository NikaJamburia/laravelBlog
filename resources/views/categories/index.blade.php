@extends('layouts.adminLayout')

@section('adminContent')

    <h2>Post Categories:</h2>

    {!!Form::open(['method' => 'post', 'action' => 'CategoriesController@delete', 'id' => 'deleteForm']) !!}
    {{Form::hidden('_method', 'DELETE')}}
    <ul class="list-group">

        @foreach($categories as $category)
            <li class="list-group-item">
                {{Form::checkbox('itemsToDelete[]', $category->id)}}
                {{$category->name}}
            </li>
        @endforeach
    </ul>

    <input type="submit" value="Delete Selected" class="btn btn-outline-danger mt-2">

    {!!Form::close() !!}

    

    <div class="p-3 mt-3 border">
        {!!Form::open(['method' => 'post', 'action' => 'CategoriesController@store',]) !!}
            <div class="row">
                <label class="ml-3" for="name">Add new catgory:</label>
            <div class="col-sm-10 col-md-11">
                {{Form::text('name', '', ['class' => 'form-control mb-2', 'placeholder' => 'Category name'])}}
            </div>

            <div class="col-sm-1 col-md-1">
                {{Form::submit('Add', ['name' => 'addCat', 'class' => 'btn btn-fluid btn-primary'])}}
            </div>
            </div>
            
        {!!Form::close() !!}
    </div>



@endsection