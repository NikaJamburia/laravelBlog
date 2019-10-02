@extends('layouts.adminLayout')

@section('adminContent')

    <h2>Website Users</h2>

    @if(count($users) > 0)
    <table class="table table-stripped table-responsive-md">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Registration Date</th>
            <th>Status</th>
            <th>Change Status</th>
            <th>Posts</th>
            <th>Comments</th>
        </tr>

        @foreach($users as $user)

        <tr>
            <td><b>{{$user->id}}</b></td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->created_at}}</td>
            <td> @if($user->admin) Admin @else Blogger @endif </td>
            <td>
                @if($user->admin)
                    {!!Form::open(['action' => ['AdminController@removeAdmin', $user->id], 'method' => 'POST']) !!} 
                        {{Form::submit('Romove Admin', ['class' => 'btn btn-primary'])}}
                    {!!Form::close() !!}
                @else 
                    {!! Form::open(['action' => ['AdminController@addAdmin', $user->id], 'method' => 'POST', 'class' => '']) !!}
                        {{Form::submit('Make Admin', ['class' => 'btn btn-primary'])}}
                    {!! Form::close() !!}
                @endif 
            </td>
            <td>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#postsModal{{$user->id}}">
                    View posts
                </button>

                <div class="modal fade" id="postsModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{$user->name}}'s posts</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @php
                                $posts = $user->posts;
                            @endphp
                            @if(count($posts) > 0)

                                <table class=" table">
                                    <thead>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th></th>
                                    </thead>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{$post->id}}</td>
                                            <td><a target="blank" href="/posts/{{$post->id}}">{{$post->title}}</a></td>
                                            <td>{!!$post->body!!}</td>
                                            <td>
                                                {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                                                    {{method_field('DELETE')}}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::hidden('AdminAction', 'a')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                            @else
                                <p>No Posts</p>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>

                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#commentsModal{{$user->id}}">
                        View Comments
                </button>
    
                    <div class="modal fade" id="commentsModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$user->name}}'s Comments</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @php
                                    $comments = $user->comments;
                                @endphp
                                @if(count($comments) > 0)
    
                                    <table class=" table">
                                        <thead>
                                            <th>ID</th>
                                            <th>Post</th>
                                            <th>Body</th>
                                            <th></th>
                                        </thead>
                                        @foreach($comments as $comment)
                                            <tr>
                                                <td><a target="blank" href="/posts/{{$comment->post->id}}#{{$comment->id}}">{{$comment->id}}</a></td>
                                                <td>{{$comment->post->title}}</td>
                                                <td>{{$comment->body}}</td>
                                                <td>
                                                    {!! Form::open(['action' => ['AdminController@deleteComment', $comment->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                                                        {{method_field('DELETE')}}
                                                        {{Form::hidden('_method', 'DELETE')}}
                                                        {{Form::hidden('deleteTarget', 'comment')}}
                                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
    
                                @else
                                    <p>No Comments found</p>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>

            </td>
        </tr>

        @endforeach

    </table>
    @else
        <p>No Posts Found</p>
    @endif

@endsection