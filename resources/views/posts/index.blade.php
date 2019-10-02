@extends('layouts.layout')

@section('content')

    <div class="clearfix">
        <h1 class="float-left">Blog</h1>
        <div class="float-right">
            <select name="" id="CategorySelector" class="form-control">
                <small>Categories:</small>
                <option value="def">All Posts</option>
                @foreach($categories as $category)
                    <option @if(isset($selectedCat) && $selectedCat == $category->id) selected = "selected" @endif value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    

    @if(count($posts) > 0)
        @foreach($posts as $post)

        <div class="card  px-2 posts-index-container text-nowrap text-truncate">
            <div class="row">
                <div class="col-sm-2 d-flex align-items-center">
                    <img src="{{asset("storage/img/$post->image")}}" class="img-fluid" alt="Cover Image">
                </div>
                
                <div class="card-body col-sm-10">
                    <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                    <hr>
                    <p>{!!$post->body!!}</p>
                    <div class="clearfix">
                        <small class="float-left">
                            Written on: {{$post->created_at}} 
                        </small>
                        <small class="float-right">
                            Author: {{$post->user->name}}
                        </small>
                    </div>
                </div>
            </div>
            
        </div>

        <div class=" mt-3 container d-flex justify-content-center">
                {{$posts->links()}}
        </div>


        @endforeach
        
    @else
        <p>No Posts found</p>
    @endif
@endsection