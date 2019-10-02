@extends('layouts.adminLayout')

@section('adminContent')

    <h2 class="mb-2">User Posts</h2>

    @if(count($posts) > 0)
    <table class="table table-stripped table-responsive-md">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Image</th>
            <th></th>
        </tr>

        @foreach($posts as $post)

        <tr>
            <td><b>{{$post->id}}</b></td>
            <td> <a target="blank" href="/posts/{{$post->id}}">{{$post->title}}</a></td>
            <td>{{$post->user->name}}</td>
            <td><img src="{{asset("storage/img/$post->image")}}" width="65" alt="Cover Image" class="img-fluid"></td>
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
        <p>No Posts Found</p>
    @endif

@endsection