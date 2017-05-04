<?php

namespace App\Providers;

use App\SocialAccount;
use App\User;
use Sentinel;
use Activation;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser, $loginWith)
    {
       
        $account = SocialAccount::whereProvider($loginWith)
            ->whereProviderUserId($providerUser->getId())
            ->first();
        
        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $loginWith
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                if($loginWith == 'twitter'){
                     $user = Sentinel::registerAndActivate([
                        'email' => $providerUser->getEmail(),
                        'first_name' => $providerUser->name,
                        'last_name' => $providerUser->nickname,
                        'password' => bcrypt(uniqid())
                    ]);
                }else{
                     $user = Sentinel::registerAndActivate([
                        'email' => $providerUser->getEmail(),
                        'first_name' => $providerUser->user['firstName'],
                        'last_name' => $providerUser->user['lastName'],
                        'password' => bcrypt(uniqid())
                    ]);
                }
               
            }
            
            $account->user()->associate($user);
            $account->save();
            $role = Sentinel::findRoleBySlug('site-user');

            $role->users()->attach($user);
            return $user;

        }

    }
}