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

    public function updateUserMetadata($userId, $role)
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