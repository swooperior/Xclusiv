<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
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
        $user = Auth::user();
        $whitelist = $user->whitelist;
        $message = null;
        $error = null;

        if($request->getMethod() == 'POST'){

            $fan = User::where('username', $request->get('fan'))->first();
            if(!is_null($fan)) {
                $whitelist = is_array($user->whitelist) ? $user->whitelist : [];
                if (!in_array($fan->id, $whitelist)) {
                    if ($fan->id != $user->id) {
                        array_push($whitelist, $fan->id);
                        $user->whitelist = $whitelist;
                        $user->save();
                        $message = 'Access granted to ' . $fan->username . ' successfully.';
                    } else {
                        $error = 'You cannot be a fan of yourself... sorry!';
                    }
                } else {
                    $error = 'Error: This user is already your fan.';
                }

            }else{
                $error = 'No account with that name was found.';
            }
        }


        $data = [
            'user' => $user,
            'whitelist' => $whitelist,
        ];
        return view('fans.grant', ['data' => $data, 'message' => $message, 'error' => $error]);
    }

    public function revoke(Request $request){

    }

    public function follow(Request $request){

    }

    public function update(Request $request){

    }
}
