<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $posts = Post::all()->take('300')->sortByDesc('id');
        $feed_posts = [];
        foreach($posts as $post){
            if($post->visible()){
                array_push($feed_posts,$post);
            }
        }
        return view('auth.dashboard', ['posts' => $feed_posts]);
    }
}
