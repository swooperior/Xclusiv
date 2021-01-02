<?php

namespace App\Http\Controllers;

use App\Utilities\CDN;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function __construct(){
        $this->middleware('account.settings');
    }

    public function single($id){
        $post = Post::find($id);

        return(view('posts.post',['post' => $post]));
    }

    public function new(Request $request){
        $user = Auth::user();
        return(view('posts.upload')->with(['user' => $user]));
    }

    public function upload(Request $request){
        $user = Auth::user();
        $post = new Post();
        $file = null;
        $privacy = $request->get('privacy');
        $file = $request->file('file');

        if(!is_null($file)){
            $file_loc = CDN::upload_media($user->id, $file);
            $post->uri = $file_loc;
        }
        if(!is_null($request->get('title'))){
            $post->title = $request->get('title');
        }
        if(!is_null($request->get('body_text'))){
            $post->body = $request->get('body_text');
        }
        $post->owner = $user->id;
        $post->privacy = $privacy;

        $post->save();

        return(view('posts.upload')->with(['user' => $user]));
    }
}
