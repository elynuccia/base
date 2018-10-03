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

    public function __construct()
    {
        $this->minorAndMajorBehaviors = new ArrayCollection();
    }



    public function getId()
    {
        return $this->id;
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


}
