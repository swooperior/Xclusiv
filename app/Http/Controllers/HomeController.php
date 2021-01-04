<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
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
            $owner = User::where('id',$post->owner)->first();
            if($post->visible()){
                //ToDo; Add check to see if current request region is in owner's restricted regions.
                array_push($feed_posts,$post);
            }
        }
        return view('auth.dashboard', ['posts' => $feed_posts]);
    }
}
