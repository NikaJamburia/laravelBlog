@extends('layouts.layout')

@section('content')

    <h1>Admin panel</h1>
    <hr>

    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-2 b-primary">
            <nav class="nav flex-column bg-dark h-auto rounded">
                <a class="nav-item admin-navigation-link text-light p-2 pl-3" href="/admin">Main page</a>
                <a class="nav-item admin-navigation-link text-light p-2 pl-3" href="/admin/posts">User Posts</a>
                <a class="nav-item admin-navigation-link text-light p-2 pl-3" href="/admin/categories">Post Categories</a>
                <a class="nav-item admin-navigation-link text-light p-2 pl-3" href="/admin/comments">User Comments</a>
                <a class="nav-item admin-navigation-link text-light p-2 pl-3" href="/admin/users">Users</a>
            </nav>
        </div>

        <div class="col-sm-6 col-md-8 col-lg-10 border rounded py-2">
            @yield('adminContent')
        </div>
    </div>

@endsection