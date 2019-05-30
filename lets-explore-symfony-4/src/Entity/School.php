<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchoolRepository")
 */
class School
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MinorAndMajorBehavior", mappedBy="school", orphanRemoval=true, cascade={"persist"})
     */
    private $minorAndMajorBehaviors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SchoolYear", mappedBy="school", orphanRemoval=true)
     */
    private $schoolYears;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numberOfCodes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Administrator", inversedBy="school", cascade={"persist", "remove"})
     */
    private $administrator;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $code;

    public function __construct()
    {
        $this->minorAndMajorBehaviors = new ArrayCollection();
        $this->schoolYears = new ArrayCollection();
    }



    public function getId()
    {
        return $this->id;
    }

    public function countMinorBehaviors()
    {
        $minorBehaviors = $this->minorAndMajorBehaviors->filter(function($minor) {
            return $minor->getIsMinorBehavior();
        });

        return count($minorBehaviors);
    }

    /**
     * @return Collection|MinorAndMajorBehavior[]
     */
    public function getMinorAndMajorBehaviors(): Collection
    {
        return $this->minorAndMajorBehaviors;
    }

    public function addMinorAndMajorBehavior(MinorAndMajorBehavior $minorAndMajorBehavior): self
    {
        if (!$this->minorAndMajorBehaviors->contains($minorAndMajorBehavior)) {
            $this->minorAndMajorBehaviors[] = $minorAndMajorBehavior;
            $minorAndMajorBehavior->setSchool($this);
        }

        return $this;
    }

    public function removeMinorAndMajorBehavior(MinorAndMajorBehavior $minorAndMajorBehavior): self
    {
        if ($this->minorAndMajorBehaviors->contains($minorAndMajorBehavior)) {
            $this->minorAndMajorBehaviors->removeElement($minorAndMajorBehavior);
            // set the owning side to null (unless already changed)
            if ($minorAndMajorBehavior->getSchool() === $this) {
                $minorAndMajorBehavior->setSchool(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SchoolYear[]
     */
    public function getSchoolYears(): Collection
    {
        return $this->schoolYears;
    }

    public function addSchoolYear(SchoolYear $schoolYear): self
    {
        if (!$this->schoolYears->contains($schoolYear)) {
            $this->schoolYears[] = $schoolYear;
            $schoolYear->setSchool($this);
        }

        return $this;
    }

    public function removeSchoolYear(SchoolYear $schoolYear): self
    {
        if ($this->schoolYears->contains($schoolYear)) {
            $this->schoolYears->removeElement($schoolYear);
            // set the owning side to null (unless already changed)
            if ($schoolYear->getSchool() === $this) {
                $schoolYear->setSchool(null);
            }
        }

        return $this;
    }

    public function getNumberOfCodes(): ?int
    {
        return $this->numberOfCodes;
    }

    public function setNumberOfCodes(?int $numberOfCodes): self
    {
        $this->numberOfCodes = $numberOfCodes;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdministrator(): ?Administrator
    {
        return $this->administrator;
    }

    public function setAdministrator(Administrator $administrator): self
    {
        $this->administrator = $administrator;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }


}
