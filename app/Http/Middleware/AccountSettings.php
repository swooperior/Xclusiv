<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Post;
use Closure;
use GuzzleHttp\Client;
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

    public static function isLocalhost(){
        $whitelist = [
            '127.0.0.1',
            'localhost',
            '::1',
            'localhost:8000'
        ];
        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return true;
        }
        return false;
    }


    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $post = Post::where('id', $request->id)->first();
        $profile = User::where('username',$request->username)->first();
        if(!is_null($post)){
            $profile = User::where('id', $post->owner)->first();
        }
        if(is_null($profile)){
            $profile = Auth::user();
        }
        $account_visibility = $profile->settings['account_settings']['account_visibility'];
        //Restrict content if account visibility is 0, logged in user is not an admin and the profile does not belong
        //to logged in user.
        if(!$user->isAdmin() && !($user == $profile) && $account_visibility == 0){
            abort(403);
        }


        $ip = $request->ip();
        $ipApiKey = config('services.ip.key');
        // make request

        $url = "http://api.ipapi.com/api/{$ip}?access_key={$ipApiKey}&security=1";
        if($this->isLocalhost()){
            $url = "http://api.ipapi.com/check?access_key={$ipApiKey}&security=1";
        }
        $client = new Client();
        $response = $client->request('GET', $url);
        $data = json_decode((string) $response->getBody(), true);
        //Change to NOT localhost when done testing.
        if($this->isLocalhost()){
            if(!$user->isAdmin() && $user != $profile && $profile->settings['privacy_settings']['region_lock'] == 1){
                if(isset($profile->settings['privacy_settings']['excluded_locations']) && is_array($profile->settings['privacy_settings']['excluded_locations'])){
                    $excluded_locations = $profile->settings['privacy_settings']['excluded_locations'];
                    foreach($data as $key => $location){
                        if(in_array($location, $excluded_locations)){
                            //Return Generic 404
                            return abort(404);
                        }
                    }
                }
            }

            //Finally check if the request is 'legitimate';
            //ToDo Move this to a firewall middleware to use globally?
            if (array_key_exists('security', $data)) {
                return $data['security']['threat_level'] === 'high' ? abort(403) : $next($request);
            }
        }

        //Bypass everything !!THIS IS BAD!!
        return $next($request);
    }
}
