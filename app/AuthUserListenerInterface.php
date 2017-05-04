<?php
namespace App;

interface AuthUserListenerInterface{

    public function userHasLoggedIn($user);
    
}