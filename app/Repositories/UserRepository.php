<?php

namespace App\Repositories;

use App\User;

class UserRepository{
    public function findByUsernameOrCreate($userData)
    {
        return User::firstOrCreate([
            'email' => $userData->email,
            //'first_name' => $userData->user->displayName,
        ]);
    }
}