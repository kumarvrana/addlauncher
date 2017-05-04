<?php

namespace App;

use Laravel\Socialite\Contracts\Factory as Socialite;
use App\Repositories\UserRepository;
use Sentinel;
use App\AuthUserListenerInterface;
class AuthenticateUser{

    private $users;

    private $socialite;

    private $sentinel;

    public function __construct(UserRepository $users, Socialite $socialite, Sentinel $sentinel)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->sentinel = $sentinel;
    }
    
    public function execute($hasCode, $loginWith, AuthUserListenerInterface $listener)
    {
        
        if(! $hasCode) return $this->getAuthorizationFirst($loginWith);

        $userData = $this->getOtherSiteLoginUser($loginWith);
        
        $user = $this->users->findByUsernameOrCreate($userData);
        
        $this->sentinel->loginAndRemember($user, true);

        return $listener->userHasLoggedIn($user);
    }

    public function getAuthorizationFirst($loginWith)
    {
        
        return $this->socialite->driver($loginWith)->redirect();
    }

    private function getOtherSiteLoginUser($loginWith)
    {
        return $this->socialite->driver($loginWith)->user();
    }
}