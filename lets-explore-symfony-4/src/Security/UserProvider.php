<?php
namespace App\Security;
use App\Utility\Auth0Api;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
class UserProvider implements UserProviderInterface, OAuthAwareUserProviderInterface {
    protected $auth0Api;
    public function __construct(Auth0Api $auth0Api)
    {
        $this->auth0Api = $auth0Api;
    }


    public function loadUserByUserId($userId)
    {
        $auth0User = $this->auth0Api->getUserByUserId($userId);

        //var_dump($auth0User->user_metadata); exit;

        if(!isset($auth0User->user_metadata)) {
            $auth0User->user_metadata  = new \stdClass();
            $auth0User->user_metadata->role = [];
            $auth0User->user_metadata->schoolCode = '';
        }

        if(!isset($auth0User->user_metadata->role) ||
            !in_array('ROLE_USER', $auth0User->user_metadata->role) ||
            !in_array('ROLE_0AUTH_USER', $auth0User->user_metadata->role)
        ) {
            //dump($auth0User); exit;
            $this->updateRoles($auth0User->user_id, $auth0User->user_metadata->role);

            $auth0User = $this->auth0Api->getUserByUserId($userId);
        }


        $username = (isset($auth0User->username)) ? $auth0User->username : $auth0User->nickname;
        $user = new User();
        $user->setEmail($auth0User->email);
        $user->setName($auth0User->name);
        $user->setGivenName($auth0User->given_name);
        $user->setPicture($auth0User->picture);
        $user->setUserId($auth0User->user_id);
        $user->setUsername($username);
        $user->setLastLogin($auth0User->last_login);
        $user->setLastIp($auth0User->last_ip);
        $user->setLoginCount($auth0User->logins_count);
        $user->setSchoolCode($auth0User->user_metadata->schoolCode);

        if(isset($auth0User->user_metadata->role)) {
            foreach ($auth0User->user_metadata->role as $role) {
                $user->addRole($role);
            }
        }

        if(isset($auth0User->user_metadata->students)) {
            $user->setStudents($auth0User->user_metadata->students);
        }

        return $user;
    }

    public function loadUserByUsername($username)
    {
        $auth0User = $this->auth0Api->getUserByUsername($username);
        //dump($auth0User); exit;

        

        if(!isset($auth0User[0]->user_metadata->role) ||
            !in_array('ROLE_USER', $auth0User[0]->user_metadata->role) ||
            !in_array('ROLE_0AUTH_USER', $auth0User[0]->user_metadata->role)
        ) {
            $this->updateRoles($auth0User[0]->user_id, $auth0User[0]->user_metadata->role);

            $auth0User = $this->auth0Api->getUserByUsername($username);
        }


        $username = (isset($auth0User[0]->username)) ? $auth0User[0]->username : $auth0User[0]->nickname;
        $user = new User();
        $user->setEmail($auth0User[0]->email);
        $user->setName($auth0User[0]->name);
        $user->setGivenName($auth0User[0]->given_name);
        $user->setPicture($auth0User[0]->picture);
        $user->setUserId($auth0User[0]->user_id);
        $user->setUsername($username);
        $user->setLastLogin($auth0User[0]->last_login);
        $user->setLastIp($auth0User[0]->last_ip);
        $user->setLoginCount($auth0User[0]->logins_count);
        $user->setSchoolCode($auth0User[0]->user_metadata->schoolCode);


        if(isset($auth0User[0]->user_metadata->role)) {
            foreach ($auth0User[0]->user_metadata->role as $role) {
                $user->addRole($role);
            }
        }

        if(isset($auth0User[0]->user_metadata->students)) {
            $user->setStudents($auth0User[0]->user_metadata->students);
        }

        return $user;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        return $this->loadUserByUserId($response->getData()['sub']);
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return User::class == $class;
    }

    public function updateRoles($userId, $roles)
    {
        $defaultRoles = array('ROLE_USER', 'ROLE_0AUTH_USER');

        $roles = (is_array($roles)) ? $roles : array();

        foreach($defaultRoles as $role) {
            $roles[] = $role;
        }

        $this->auth0Api->updateRoleUserMetadata($userId, array_unique($roles));
    }

    public function updateSchoolCode($userId, $schoolCode)
    {

        $this->auth0Api->updateSchoolCodeUserMetadata($userId, $schoolCode);
    }


}