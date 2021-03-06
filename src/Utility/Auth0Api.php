<?php
namespace App\Utility;
use GuzzleHTTP\Client as GuzzleClient;

class Auth0Api {
    private $authorizationHeader;
    private $baseUri;
    private $guzzleClient;
    public function __construct($authorizationHeader, $baseUri, GuzzleClient $guzzleClient)
    {
        $this->authorizationHeader = $authorizationHeader;
        $this->baseUri = $baseUri;
        $this->guzzleClient = $guzzleClient;
    }

    public function getUserByUserId($userId)
    {
        $response = $this->guzzleClient->request('GET', $this->baseUri . 'users/' . $userId, array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
        ));
        return json_decode($response->getBody()->getContents());
    }

    public function getUserByUsername($username)
    {
        $response = $this->guzzleClient->request('GET', $this->baseUri . 'users', array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
            'query' => array(
                'q' => 'nickname=' . $username. '* OR nickname=' . $username . '*'
            )
        ));
        return json_decode($response->getBody()->getContents());
    }

    public function getUsersBySchoolCode($schoolCode)
    {
        $usersArray= array();

        $response = $this->guzzleClient->request('GET', $this->baseUri . 'users', array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
            'query' => array(
                'q' => 'user_metadata.schoolCode=' . $schoolCode
            )
        ));

        foreach(json_decode($response->getBody()->getContents()) as $user) {
            $roles = array();

            foreach($user->user_metadata->role as $role) {
                switch($role) {
                    case 'ROLE_USER':
                    case 'ROLE_0AUTH_USER':
                        break;

                    case 'ROLE_USER_PBS_TEAM_MEMBER':
                        $roles[]  = 'PBS team member';

                        break;

                    case 'ROLE_USER_TEACHER_COORDINATOR':
                        $roles[] = 'Teacher coordinator';

                        break;

                    case 'ROLE_USER_SCHOOLS_COORDINATOR':
                        $roles[] = 'Schools coordinator';

                        break;

                }
            }

            $userName = $user->name . ' ('. implode(', ', $roles) . ')';

            $usersArray[$userName] = $user->user_id;
        }

        return $usersArray;
    }

    public function getUsers()
    {
        $response = $this->guzzleClient->request('GET', $this->baseUri . 'users', array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            )
        ));
        return json_decode($response->getBody()->getContents());
    }

    public function getUsersIdAndName()
    {
        $usersArray= array();

        $response = $this->guzzleClient->request('GET', $this->baseUri . 'users', array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            )
        ));

        foreach(json_decode($response->getBody()->getContents()) as $user) {
            $usersArray[$user->name] = $user->user_id;
        }

        return $usersArray;
    }


    public function initUserMetadata($userId)
    {
        $response = $this->guzzleClient->patch($this->baseUri . 'users/' . $userId, array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
            'form_params' => [
                'user_metadata' => '{}'
            ],
        ));
        //student

        return json_decode($response->getBody()->getContents());

    }

    public function updateRoleUserMetadata($userId, $role)
    {
        $response = $this->guzzleClient->patch($this->baseUri . 'users/' . $userId, array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
            'form_params' => [
                'user_metadata' => ['role' => $role]
            ],
        ));
        //student

        return json_decode($response->getBody()->getContents());
    }

    public function updateSchoolCodeUserMetadata($userId, $schoolCode)
    {
        $response = $this->guzzleClient->patch($this->baseUri . 'users/' . $userId, array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
            'form_params' => [
                'user_metadata' => ['schoolCode' => $schoolCode]
            ],
        ));


        return json_decode($response->getBody()->getContents());
    }

    public function updateStudentUserMetadata($userId, $students)
    {
        $response = $this->guzzleClient->patch($this->baseUri . 'users/' . $userId, array(
            'headers' => array (
                'Authorization' => $this->authorizationHeader
            ),
            'form_params' => [
                'user_metadata' => ['students' => json_encode($students)]
            ],
        ));
        //student

        return json_decode($response->getBody()->getContents());
    }

}