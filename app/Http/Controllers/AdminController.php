<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Likes_users;
use App\Comment;
use App\Reply;
use App\Category;
use Auth;


class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isAdmin');
    }

    // public function checkForAdmin()
    // {
    //     if(!Auth::user()->admin){
    //         return redirect('/');
    //     }
    // }

    public function index()
    {

        return view('admin/index');
    }

    public function posts()
    {

        $posts = Post::all();

        return view('admin/posts')->with('posts', $posts);
    }

    public function comments()
    {

        $comments = Comment::all();

        return view('admin/comments')->with('comments', $comments);
    }

    public function users()
    {
        $users = User::all();

        return view('admin/users')->with('users', $users);
    }

    /**
     * Remove the specified comment or reply from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteComment(request $request, $id)
    {

        if($request['deleteTarget'] == 'comment'){
            Reply::where('comment_id', $id)->delete();
            Comment::where('id', $id)->delete();

            return redirect('/admin/comments')->with('success', 'Comment Removed');
        }

        else if($request['deleteTarget'] == 'reply'){
            Reply::where('id', $id)->delete();

            return redirect('/admin/comments')->with('success', 'Reply Removed');
        }
    }

    /**
     * Grant admin privileges to a specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addAdmin($id)
    {

        $user = User::find($id);
        $user->admin = true;
        $user->save();

        return redirect('/admin/users')->with('success', "Admin Privileges granted");

    }

    /**
     * Remove admin privileges from a specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeAdmin($id)
    {

        $user = User::find($id);
        $user->admin = false;
        $user->save();

        return redirect('/admin/users')->with('success', "Admin Privileges removed");

    }
}
