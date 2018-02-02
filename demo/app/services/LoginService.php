<?php

namespace services;

use models\User;
use Phalcon\Mvc\User\Component;
use models\Admin;

/**
 * Phalcon\UserPlugin\Acl\Acl.
 */
class LoginService extends Component
{

    private $loginUser = null;

    public function __construct()
    {
    }


    /**
     * @return User|null
     */
    public function getLoginUser()
    {
        return $this->loginUser;
    }

    /**
     * @param string $client encrypted text
     * @param string $randKey
     * @return bool
     */
    public function isLogin(string $client = null, string $randKey = null): bool 
    {
        if(!$client and !$randKey){
            $client = $this->request->getServer("PHP_AUTH_USER");
            $randKey = $this->request->getServer("PHP_AUTH_PW");
        }
        $client = $this->crypt->decryptBase64($client);

        /** @var User $loginUser */
        $loginUser = $this->loginUser;

        if(!is_null($this->loginUser) && $this->loginUser === false){
            return false;
        }

        if( is_null($this->loginUser)
            || $loginUser->getAccessToken() !== $randKey
            || $loginUser->getClient() !== $client ) {

            $user = User::findFirst(
                [
                'conditions' => 'client = ?0 and rand_key = ?1',
                'bind' => [
                    $client,
                    $randKey
                ]
                ]
            );

            if($user ===false || intval($user->getExpiry())<time()){
                $this->loginUser = false;
                return false;
            }else{
                $this->loginUser = $user;
                return true;
            }
        }

        return true;
    }
}