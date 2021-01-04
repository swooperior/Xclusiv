<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    //Privacy setting
    //0 = Exclusive (Must be subscribed or whitelisted to a user)
    //1 = Purchasable (Can purchase access to the content)
    //2 = Public (Viewable by guests (Non-logged-in users))

    public function user(){
        return $this->belongsTo(User::class, 'owner');
    }

    public function visible($admin=false){
        $visible = false;
        $isAdmin = false;
        $isOwner  = false;
        $isPurchased = false;
        $isWhitelisted = false;
        $ownerUser = User::where('id',$this->owner)->first();

        if(Auth::check()){
            if($admin){
                $isAdmin = Auth::user()->role == 1;
            }
            $isOwner = Auth::user()->id == $this->owner;
            $isWhitelisted = in_array(Auth::user()->id, $ownerUser->whitelist);
            $isPurchased = !is_null(Payment::where('content_id',$this->id)->where('user_id', Auth::user()->id)->first());
        }

        switch($this->privacy){
            case(0): //Exclusive Content must be in whitelist
                $visible = $isWhitelisted;
                break;
            case(1): //Public content available to everyone
                $visible = true;
                break;
            case(2): //Purchasable content only available when paid for.
                $visible = $isPurchased;
                break;
            default:
                $visible = false;
                break;
        }

        /* Overrides
        *
        *
        */



        //ToDo; Region locking post at model level;
        if($ownerUser->settings['privacy_settings']['region_lock'] == 1){
            if(is_array($ownerUser->settings['privacy_settings']['excluded_locations']) && count($ownerUser->settings['privacy_settings']['excluded_locations']) > 0){
                $excluded_locations = $ownerUser->settings['privacy_settings']['excluded_locations'];
                if(!is_null(session('ip_data'))){
                    $ip_data = session('ip_data');
                    foreach($ip_data as $key => $location){
                        if(in_array($location, $excluded_locations)){
                            $visible = false;
                        }
                    }
                }
            }
        }


        //Account Settings overrides:
        if($ownerUser->settings['account_settings']['account_visibility'] == 0){
            $visible = false;
        }



        return $visible || $isAdmin || $isOwner;

    }
}
