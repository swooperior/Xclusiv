<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utilities\CDN;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('account.settings');
    }

    public function index(Request $request){
        $user = User::where('username',$request->username)->first();
        if(is_null($request->username)){
            $user = Auth::user();
        }
        if(is_null($user)){
            return abort(404);
        }

        $products = Post::where('privacy', 2)
                            ->where('owner',$user->id)
                            ->orderBy('id','desc')
                            ->get();


        return view('auth.profile')->with(['user' => $user, 'products' => $products]);
    }

    public function update(){
        //
    }
}
