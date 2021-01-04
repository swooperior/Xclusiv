<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AccountSettings;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated($request, $user)
    {
        //Check IPApi and store response in session variable.
        $ip = $request->ip();
        $ipApiKey = config('services.ip.key');
        // make request

        $url = "http://api.ipapi.com/api/{$ip}?access_key={$ipApiKey}&security=1";
        if(AccountSettings::isLocalhost()){
            $url = "http://api.ipapi.com/check?access_key={$ipApiKey}&security=1";
        }
        $client = new Client();
        $response = $client->request('GET', $url);
        $data = json_decode((string) $response->getBody(), true);

        //Each post can then check the session variable to determine if it is visible or not.
        $request->session()->put('ip_data', $data);
    }
}
