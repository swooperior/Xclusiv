<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictedContent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if(!is_null($user)){
            (array)$whitelist = $user->whitelist;
            if(!in_array($user->id, $whitelist)){
                return redirect(route('error.restricted'));
            }
        }

        return $next($request);
    }
}
