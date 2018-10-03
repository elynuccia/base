<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MinorAndMajorBehaviorRepository")
 */
class MinorAndMajorBehavior
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
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMinorBehavior;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\School", inversedBy="minorAndMajorBehaviors", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $school;

    public function getId()
    {
        return $this->id;
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

    public function getIsMinorBehavior(): ?bool
    {
        return $this->isMinorBehavior;
    }

    public function setIsMinorBehavior(bool $isMinorBehavior): self
    {
        $this->isMinorBehavior = $isMinorBehavior;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }
}
