<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public static $settings = [
        'profile_privacy',
        'gender',
        'excluded_loc',
        'payment_type',
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(){
        return view('auth.settings.all');
    }

    public function profile(Request $request){
        $user = Auth::user();

        if($request->getMethod() == 'POST'){
            $profileImg = $request->request->get('profile_image');
            $coverPhoto = $request->request->get('cover_photo');
            $bio = $request->request->get('bio');
            //Handle File Uploads

            //Update user values
            if(!is_null($profileImg)){
                $user->profile_image = $profileImg;
            }
            if(!is_null($coverPhoto)){
                $user->settings['cover_photo'] = $coverPhoto;
            }
            if(!is_null($bio)){
                $user->bio = $bio;
            }
            $user->save();
            return view('auth.settings.profile', ['user' => $user, 'message' => 'Profile updated successfully!']);
        }else{
            return view('auth.settings.profile', ['user' => $user]);
        }
    }

    public function account(Request $request){
        $user = Auth::user();

        if($request->getMethod() == 'POST'){
            //Handle saving settings
        }else{
            return view('auth.settings.account')->with(['user' => $user]);
        }

    }

    public function privacy(Request $request){
        $user = Auth::user();

        if($request->getMethod() == 'POST'){
            //Handle saving settings
        }else{
            return view('auth.settings.privacy')->with(['user' => $user]);
        }

    }

}
