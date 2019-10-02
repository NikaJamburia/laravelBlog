@extends('layouts/layout')

@section('content')

    <div class="jumbotron text-center">
        <h1>Welcome To My App</h1>
        <p>some random text</p>

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-success">Register</a>
        @else
            <p>Hello {{auth()->user()->name}}</p>
        @endguest
    </div>

@endsection