<?php

namespace App\Utilities;

use App\Models\User;

class UserAttributes{

    public static $settings = [
        'profile_settings' => [
            'gender' => 'F',
            'profile_image' => null,
            'cover_image' => null,
            'header_text_color' => 'dark',
        ],
        'account_settings' => [
            'account_visibility' => 1,
            'email_settings' => [],
            'tracking_settings' => [],
        ],
        'privacy_settings' => [
            'region_lock' => 0,
            'default_post_visibility' => 0,
            'secret_mode' => 0,
        ],
        'payment_settings' => [
            'payment_setting_name' => 'Exclusive',
            'payment_setting_price' => '4.99',
            'payment_setting_currency' => 'GBP',
        ],
    ];

    public static function instantiate(User $user){
        //Instantiates a user with attributes.
        if($user->settings = [] ||  !is_array($user->settings)){
            $user->settings = self::$settings;
            $user->save();
        }
    }
}
