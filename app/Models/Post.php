<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Privacy setting
    //0 = Exclusive (Must be subscribed or whitelisted to a user)
    //1 = Purchasable (Can purchase access to the content)
    //2 = Public (Viewable by guests (Non-logged-in users))

    public function user(){
        $this->belongsTo('App\Models\User');
    }


}
