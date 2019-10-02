@extends('layouts.layout')

@section('content')

    <a href="/posts" class="btn btn-secondary">Back</a>

    <div class="card mt-3 px-2">
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

        <div class="my-2">  
                @if(Auth::guest())
                    <small> Log in to be able to like this post</small>
                @else
                    @if(Auth::user()->id != $post->user->id)
                        @if($liked)
                            
                            {!! Form::open(['action' => ['PostsController@removeLike', $post->id], 'method' => 'POST', 'class' => 'col-1']) !!}
                                {{Form::submit('Unlike', ['class' => 'btn btn-primary active', 'name' => 'unlike'])}}
                            {!! Form::close() !!}

                        @else
                            {!! Form::open(['action' => ['PostsController@addLike', $post->id], 'method' => 'POST', 'class' => 'col-1']) !!}
                                {{Form::submit('Like', ['class' => 'btn btn-primary', 'name' => 'like'])}}
                            {!! Form::close() !!}
                        @endif
                    @endif
                @endif 
                <div class="ml-3 mt-1">
                        Likes
                    <span class="badge badge-secondary">  {{$post->likes}} </span>
                </div>      
        </div>
    </div>

    @if(!Auth::guest())
    @if(Auth::user()->id == $post->user->id)
    <div class="clearfix mt-4">
        <a href="{{$post->id}}/edit" class="btn btn-primary float-left">Edit Post</a>

        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
            {{method_field('DELETE')}}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!! Form::close() !!}
    </div>
    @endif
    @endif

    <div class="container px-5 mt-4">
        <hr>

        <div class= "mb-3">
            <ul class="list-group">
                <li class="list-group-item" style="background: #dadada"><h5>Leave a comment:</h5></li>
                
                    {!! Form::open(['action' => ['PostsController@addComment', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                        {{Form::textarea('body', '', ['class' => 'form-control noresize', 'rows' => '3'])}}
                        <div class="clearfix">
                            {{Form::submit('Post', ['class' => 'btn btn-primary mt-2 float-right', 'name' => 'comment'])}}
                        </div>
                    {!! Form::close() !!}
                
            </ul>
        </div>

        <hr>

        @if(count($comments) > 0)

            @foreach($comments as $comment)

                <div class="media border p-3 mb-3" id="{{$comment->id}}">
                    <img src="{{asset("storage/img/img_avatar3.png")}}" alt="" class="rounded-circle mr-3" width="60">

                    <div class="media-body">
                        <h4>{{$comment->user->name}} <small class="ml-3"><i>Posted on {{$comment->created_at}}</i></small></h4>
                        <p>{{$comment->body}}</p>

                        <button class="btn mb-2 btn-sm btn-secondary" onclick="showForm(event, {{$comment->id}})">Reply</button>

                        <div id="replyForm{{$comment->id}}" class="d-none">
                            {!! Form::open(['action' => ['PostsController@addReply', $comment->id], 'method' => 'POST']) !!}
                                {{Form::hidden('post_id', $post->id )}}
                                <div class="row">
                                    <div class="col-10">
                                        {{Form::textarea('body', '', ['class' => 'form-control ', 'rows' => '3'])}}
                                    </div>

                                    <div class="col-2">
                                        {{Form::submit('Reply', ['class' => 'btn btn-sm btn-primary mt-2', 'name' => 'comment'])}}
                                    </div>
                                </div>

                            {!! Form::close() !!} 

                        </div>

                        @php
                            $replies = App\Reply::where('comment_id', $comment->id)->get();
                        @endphp

                        @if(count($replies) > 0)
                            @foreach($replies as $reply)

                                <div class="media  p-3" id="r{{$reply->id}}">
                                    <img src="{{asset("storage/img/img_avatar3.png")}}" alt="" class="rounded-circle mr-3" width="60">
                                    <div class="media-body">
                                        <h4>{{$reply->user->name}} <small class="ml-3"><i>Replied on {{$reply->created_at}}</i></small></h4>
                                        <p>{{$reply->body}}</p>
                                    </div>
                                </div>

                            @endforeach
                        @endif

                    </div>

                </div>

            @endforeach

        @else
            <p>No Comments for this post</p>
        @endif


    </div>

    
    

@endsection