<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
* Controls interactions between fans and content creators.
*/

class FansController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function main($user=null){
        $user = $user ?? Auth::user();

        $data = [];

        $data['fans'] = $user->whitelist;
        $data['user'] = $user;
        $data['sales'] = Payment::where('owner_id', $user->id)->get();
        return view('fans.fans', ['data' => $data]);
    }

    public function grant(Request $request){

    }

    public function revoke(Request $request){

    }

    public function follow(Request $request){

    }

    public function update(Request $request){

    }
}
