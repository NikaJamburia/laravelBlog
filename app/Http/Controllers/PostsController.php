<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;
use App\Likes_users;
use App\Comment;
use App\Reply;
use App\Category;
use Auth;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' =>['index', 'show', 'addComment', 'addReply', 'ShowByCategory']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','DESC')->paginate(10);
        $categories = Category::all();

        return view('posts/index')->with('posts', $posts)->with('categories', $categories);
    }

        /**
     * Display a listing of the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ShowByCategory($id)
    {
        $posts = Post::where('category', $id)->orderBy('created_at','DESC')->paginate(10);
        $categories = Category::all();

        return view('posts/index')->with('posts', $posts)->with('categories', $categories)->with('selectedCat', $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "image" => "image|nullable|max:1999"
        ]);

        if($request->hasFile('image')){
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('image')->getClientOriginalExtension();

            $fileNameToStore = $fileName."_".time().".".$extension;

            $path = $request->file("image")->storeAs('public/img', $fileNameToStore);

        }
        else{
            $fileNameToStore = "defaultimage.png";
        }

        $post = new Post();
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->user_id = auth()->user()->id;
        $post->image = $fileNameToStore;
        $post->category = $request['category'];
        $post->likes = 0;
        $post->save();
        
        return redirect('/posts')->with('success', "Post Created");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        $likes = [];
        if(isset(auth()->user()->id)){
            $user_id = auth()->user()->id;
            $likes = Likes_users::where(['user_id' => $user_id, 'post_id' => $id])->get();
        }
        
        $liked = false;
        if(count($likes) > 0){
            $liked = true;
        }
        else{
            $liked = false;
        }

        $comments = Comment::where('post_id', $id)->orderBy('created_at', 'DESC')->get();

        return view('posts/show')->with('post', $post)->with('liked', $liked)->with('comments', $comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all();

        if(auth()->user()->id == $post->user_id){
            return view('posts/edit')->with('post', $post)->with('categories', $categories)->with('selectedCat', $post->category);
        }
        else{
            return redirect('posts')->with('error', "You dont have access to this post");
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $this->validate($request, [
            "title" => "required",
            "body" => "required",
            "image" => "image|nullable|max:1999"
        ]);

        if($request->hasFile('image')){
            $fileNameWithExt = $request->file('image')->getClientOriginalName();

            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            $extension = $request->file('image')->getClientOriginalExtension();

            $fileNameToUpdate = $fileName."_".time().".".$extension;

            $path = $request->file("image")->storeAs('public/img', $fileNameToUpdate);

            $post->image = $fileNameToUpdate;
        }

        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->category = $request['category'];
        $post->save();

        return redirect('posts/'.$id)->with('success', "Post Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request, $id)
    {
        $post = Post::find($id);

        if(auth()->user()->id == $post->user_id || auth()->user()->admin){

            if($post->image != "defaultimage.png"){
                Storage::delete("public/img/$post->image");
            }

            $post->delete();
            if(isset($request['AdminAction'])){
                return redirect('admin/posts')->with('success', "Post Deleted");
            }
            else{
                return redirect('posts')->with('success', "Post Deleted");
            }
            

        }
        else{
            return redirect('posts')->with('error', "You dont have access to this post");
        }
        
    }

        /**
     * Add like to specified post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addLike($id)
    {
        if(isset($_POST['like'])){

            $post = Post::find($id);
            $post->likes++;
            $post->save();

            $likes_users = new Likes_users;
            $likes_users->user_id = auth()->user()->id;
            $likes_users->post_id = $id;
            $likes_users->save();

            return redirect("/posts/$id");
        }
        else{
            return redirect("/posts")->with('error', 'Unauthorised action');
        }
    }

    /**
     * Unlike specified post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeLike($id)
    {
        if(isset($_POST['unlike'])){

            $post = Post::find($id);
            $post->likes--;
            $post->save();

            Likes_users::where(['post_id' => $id, 'user_id' => auth()->user()->id])->delete();

            return redirect("/posts/$id");
        }
        else{
            return redirect("/posts")->with('error', 'Unauthorised action');
        }
    }

    /**
     * Add Comment to specified post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addComment(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        if(isset($request['comment'])){

            if(Auth::guest()){
                return redirect("/posts/$id")->with('error', "You have to be logged in to leave comments");
            }

            $comment = new Comment();
            $comment->body = $request['body'];
            $comment->post_id = $id;
            $comment->user_id = auth()->user()->id;
            $comment->save();

            return redirect("/posts/$id")->with('success', "Comment added!");
        }
    }

        /**
     * Add reply to specified comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addReply(Request $request, $id)
    {
        $post_id = $request['post_id'];

        $this->validate($request, [
            'body' => 'required'
        ]);

        if(isset($request['comment'])){

            if(Auth::guest()){
                return redirect("/posts/$post_id")->with('error', "You have to be logged in in order to reply");
            }

            $reply = new Reply();
            $reply->body = $request['body'];
            $reply->comment_id = $id;
            $reply->user_id = auth()->user()->id;
            $reply->save();

            return redirect("/posts/$post_id")->with('success', "Reply added!");
        }
    }

}
