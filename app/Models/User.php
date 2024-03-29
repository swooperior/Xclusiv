<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'whitelist',
        'settings',
        'settings->account_settings->account_visibility'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $attributes = [
        'settings' => '{}',
        'whitelist' => '{}',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array',
        'whitelist' => 'array',
    ];

    public function posts(){
        $this->hasMany('\App\Models\Post');
    }

    //ToDo; Change this to actually use roles table.
    public function isAdmin(){
        if($this->role == 1){
            return true;
        }
        return false;
    }
}
