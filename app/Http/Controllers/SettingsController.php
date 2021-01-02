<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utilities\CDN;
use App\Utilities\UserAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function all(){
        //
        return view('auth.settings.all');
    }

    public function profile(Request $request){
        $user = Auth::user();
        $updatedSettings = $user->settings;

        if($request->getMethod() == 'POST'){
            $profileImg = $request->file('profile_image');
            $coverPhoto = $request->file('cover_image');
            $bio = $request->get('bio');
            $header_text = $request->get('text_color');

            //Update user values
            if(!is_null($profileImg)){
                $file_loc = CDN::upload_media($user->id, $profileImg);
                $updatedSettings['profile_settings']['profile_image'] = $file_loc;
            }
            if(!is_null($coverPhoto)){
                $file_loc = CDN::upload_media($user->id, $coverPhoto);
                $updatedSettings['profile_settings']['cover_image'] = $file_loc;
            }
            if(!is_null($bio)){
                $user->bio = $bio;
            }
            if(!is_null($header_text)){
                if($header_text == 'light'){
                    $header_text = '#fff';
                }else{
                    $header_text = '#000';
                }
                $updatedSettings['profile_settings']['header_text_color'] = $header_text;
            }


            $user->settings = $updatedSettings;
            $user->save();
            return view('auth.settings.profile', ['user' => $user, 'message' => 'Profile updated successfully!']);
        }else{
            return view('auth.settings.profile', ['user' => $user]);
        }
    }

    public function account(Request $request){
        //ToDo; Modify so function can be accessed for given user by adminsitrator to update details.
        $user = Auth::user();

        if($request->getMethod() == 'POST'){
            $updatedSettings = $user->settings;
            $settings = [
                'account_visibility' => $request->get('account_visibility'),
                'email_settings' => $request->get('email_settings'),
                'tracking_settings' => $request->get('tracking_settings'),
            ];

            foreach($settings as $setting => $value){
                if(!is_null($value)){
                    $updatedSettings['account_settings'][$setting] = $value;
                }
            }
            $user->settings = $updatedSettings;
            $user->save();
            return view('auth.settings.account')->with(['user' => $user, 'message' => 'Settings updated successfully.']);
        }else{
            return view('auth.settings.account')->with(['user' => $user]);
        }

    }

    public function privacy(Request $request){
        $user = Auth::user();
        $updatedSettings = $user->settings;
        $regionLock = $request->get('region_lock');
        $regionSelect = $request->get('region_select');
        $del_array = $request->get('del_chk');
        if($request->getMethod() == 'POST'){
            //Handle saving settings
            if(!is_null($regionLock)){
                $updatedSettings['privacy_settings']['region_lock'] = $regionLock;
                if(!isset($updatedSettings['privacy_settings']['excluded_locations'])){
                    $updatedSettings['privacy_settings']['excluded_locations'] = [];
                }

                if(!is_null($regionSelect)){
                    array_push($updatedSettings['privacy_settings']['excluded_locations'],$regionSelect);
                }
                if(!is_null($del_array)){

                    foreach($del_array as $item => $location){
                        $key = array_search($location, $updatedSettings['privacy_settings']['excluded_locations']);

                        if($key !== false){
                            unset($updatedSettings['privacy_settings']['excluded_locations'][$key]);
                        }
                    }
                }
            }
            $user->settings = $updatedSettings;
            //dd($updatedSettings);
            $user->save();
            $message = 'Settings updated successfully.';
            return view('auth.settings.privacy')->with(['user' => $user, 'message' => $message]);
        }else{
            return view('auth.settings.privacy')->with(['user' => $user]);
        }

    }

}
