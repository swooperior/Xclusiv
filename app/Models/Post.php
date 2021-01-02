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
        return $this->belongsTo('App\Models\User');
    }

    public function visible(){
        $visible = false;
        $isAdmin = false;
        $isOwner  = false;
        $isPurchased = false;
        $isWhitelisted = false;

        if(Auth::check()){
            $isAdmin = Auth::user()->role == 1;
            $isOwner = Auth::user()->id == $this->owner;
            $isWhitelisted = in_array(Auth::user()->id, User::where('id',$this->owner)->first()->whitelist);
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
                break;
        }
        return $visible || $isAdmin || $isOwner;
    }


}
