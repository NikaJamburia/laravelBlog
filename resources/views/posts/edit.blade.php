@extends('layouts.layout')

@section('content')

    <!-- <a href="/posts" class="btn btn-secondary mb-1">Back</a> -->

    <h1>Edit Post</h1>

    <form method="post" action="{{action('PostsController@update', $post->id)}}" enctype="multipart/form-data"  class="">
        {{method_field('PUT')}}
        @csrf
        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control">
                @foreach($categories as $category)
                    <option @if(isset($selectedCat) && $selectedCat == $category->id) selected = "selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}">
        </div>
        <div class="form-group">
            <label for="article-ckeditor">Text:</label>
            <textarea name="body" id="article-ckeditor" class="form-control" cols="30" rows="10">
                {{$post->body}}
            </textarea>
        </div>
        <input type="hidden" name="" _method="put">

        <div class="form-group">
            <label for="image">Cover Image:</label>
            <div class="row">
                <div class="col-2">
                    <img src="{{asset("storage/img/$post->image")}}" class="img-fluid" id="img" alt="Cover Image">
                </div>

                <div class="col-10">
                    <br>
                    <input type="file" name="image" id="imgInput" id="image">
                </div>
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Save Changes">
    </form>

@endsection