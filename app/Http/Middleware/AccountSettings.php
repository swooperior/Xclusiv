<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountSettings
{
    /**
     * Handle an incoming request.
     * Checks if user's settings need to be enforced on request to their profile or content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $profile = User::where('username',$request->username)->first();
        if(is_null($profile)){
            $profile = Auth::user();
        }
        $account_visibility = $profile->settings['account_settings']['account_visibility'];
        //Restrict content if account visibility is 0, logged in user is not an admin and the profile does not belong
        //to logged in user.
        if(!$user->isAdmin() && !($user == $profile) && $account_visibility == 0){
            abort(403);
        }

        return $next($request);
    }
}
