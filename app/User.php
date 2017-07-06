<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'first_name', 'last_name', 'password', 'phone_number', 'permissions'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function byEmail($email)
    {
        return static::whereEmail($email)->first();

    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    
}
