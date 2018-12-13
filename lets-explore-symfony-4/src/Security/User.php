<?php
namespace App\Security;
use Symfony\Component\Security\Core\User\UserInterface;
class User implements UserInterface
{
    protected $email;
    protected $name;
    protected $givenName;
    protected $familyName;
    protected $picture;
    protected $username;
    protected $userId;
    protected $lastLogin;
    protected $lastIp;
    protected $loginCount;
    protected $roles = array('ROLE_USER', 'ROLE_0AUTH_USER');
    protected $students= array();


    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @param mixed $familyName
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
    }
    /**
     * @return mixed
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }
    /**
     * @param mixed $givenName
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }
    /**
     * @return mixed
     */
    public function getGivenName()
    {
        return $this->givenName;
    }
    /**
     * @param mixed $lastIp
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;
    }
    /**
     * @return mixed
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }
    /**
     * @param mixed $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }
    /**
     * @return mixed
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    /**
     * @param mixed $loginCount
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;
    }
    /**
     * @return mixed
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
    /**
     * @return mixed
     */
    public function getPicture()
    {
        return $this->picture;
    }
    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getStudents()
    {
        return json_decode($this->students);
    }

    public function setStudents($students)
    {
        $this->students = $students;
    }

    public function addStudent(array $student)
    {
        $this->students[] = $student;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return null;
    }
    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }
    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        return true;
    }
    /**
     * {@inheritdoc}
     */
    public function equals(UserInterface $user)
    {
        return $user->getUsername() === $this->username;
    }
}