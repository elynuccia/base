<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdministratorRepository")
 */
class Administrator
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $personalMail;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\School", mappedBy="administrator", cascade={"persist", "remove"})
     */
    private $school;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPersonalMail(): ?string
    {
        return $this->personalMail;
    }

    public function setPersonalMail(string $personalMail): self
    {
        $this->personalMail = $personalMail;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(School $school): self
    {
        $this->school = $school;

        // set the owning side of the relation if necessary
        if ($this !== $school->getAdministrator()) {
            $school->setAdministrator($this);
        }

        return $this;
    }
}
