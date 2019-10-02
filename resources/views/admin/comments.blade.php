@extends('layouts.adminLayout')

@section('adminContent')

    <h2>Comments</h2>

    @if(count($comments) > 0)
    <table class="table table table-responsive-md">
        <tr>
            <th>ID</th>
            <th>Post</th>
            <th>Author</th>
            <th>Text</th>
            <th></th>
            <th></th>
        </tr>

        @foreach($comments as $comment)

        <tr>
            <td><b> <a href="/posts/{{$comment->post->id}}#{{$comment->id}}">{{$comment->id}}</a> </b></td>
            <td> <a target="blank" href="/posts/{{$comment->post->id}}">{{$comment->post->title}}</a></td>
            <td>{{$comment->user->name}}</td>
            <td>{{$comment->body}}</td>
            <td>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#repliesModal{{$comment->id}}">
                    View replies
                </button>

                <div class="modal fade" id="repliesModal{{$comment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Replies for comment {{$comment->id}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @php
                                $replies = App\Reply::where('comment_id', $comment->id)->get();
                            @endphp
                            @if(count($replies) > 0)

                                <table class=" table">
                                    <thead>
                                        <th>ID</th>
                                        <th>Author</th>
                                        <th>Text</th>
                                        <th></th>
                                    </thead>
                                    @foreach($replies as $reply)
                                        <tr>
                                            <td><a href="/posts/{{$comment->post->id}}#r{{$reply->id}}">{{$reply->id}}</a></td>
                                            <td>{{$reply->user->name}}</td>
                                            <td>{{$reply->body}}</td>
                                            <td>
                                                {!! Form::open(['action' => ['AdminController@deleteComment', $reply->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                                                    {{method_field('DELETE')}}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::hidden('deleteTarget', 'reply')}}
                                                    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                            @else
                                <p>No Replies</p>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            </td>
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
        <p>No Comments Found</p>
    @endif

@endsection