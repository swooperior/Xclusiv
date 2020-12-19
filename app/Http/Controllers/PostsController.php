<?php

namespace App\Http\Controllers;

use App\Utilities\CDN;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(){

    }

    public function single($id){
        $post = Post::find($id);

        return(view('posts.post',['post' => $post]));
    }

    public function new(Request $request){
        //if get request

        return(view('posts.upload'));
    }

    public function upload(Request $request){
        $user = Auth::user();
        $post = new Post();
        $file = null;
        $privacy = $request->get('privacy');
        $file = $request->file('file');
        $file_loc = CDN::upload_media($user->id, $file);
        $post->owner = $user->id;
        $post->privacy = $privacy;
        $post->uri = $file_loc;
        $post->save();

        return(view('posts.upload'));
    }
}
