<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utilities\CDN;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $user = User::where('username',$request->username)->first();
        if(is_null($user)){
            $user = Auth::user();
        }

        return view('auth.profile')->with(['user' => $user]);
    }

    public function update(){
        //
    }
}
