@extends('layouts.layout')

@section('content')

    <!-- <a href="/posts" class="btn btn-secondary mb-1">Back</a> -->

    <h1>Create New Post</h1>

    <form method="POST" action="/posts"  class="" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-control">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="article-ckeditor">Text:</label>
            <textarea name="body" id="article-ckeditor" class="form-control" cols="30" rows="10"></textarea>
        </div>
        <div class="form-group">
            <label for="image">Cover Image:</label>
            <br>
            <input type="file" name="image" id="image" >
        </div>

        <input type="submit" class="btn btn-primary" value="Post">
    </form>

@endsection