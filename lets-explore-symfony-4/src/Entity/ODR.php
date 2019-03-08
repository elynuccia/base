<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ODRRepository")
 */
class ODR
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MinorAndMajorBehavior", inversedBy="oDRs")
     */
    private $minorAndMajorBehaviors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LocationTag", inversedBy="oDRs")
     */
    private $locations;

    /**
     * @ORM\Column(type="text")
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fillInDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="oDRs")
     */
    private $student;

    public function __construct()
    {
        $this->minorAndMajorBehaviors = new ArrayCollection();
        $this->locations = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeMinorAndMajorBehavior(MinorAndMajorBehavior $minorAndMajorBehavior): self
    {
        if ($this->minorAndMajorBehaviors->contains($minorAndMajorBehavior)) {
            $this->minorAndMajorBehaviors->removeElement($minorAndMajorBehavior);
        }

        return $this;
    }

    /**
     * @return Collection|LocationTag[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(LocationTag $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
        }

        return $this;
    }

    public function removeLocation(LocationTag $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
        }

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getFillInDate()
    {
        return ($this->fillInDate instanceof \DateTime) ? $this->fillInDate->format('Y-m-d') : null;
    }

    public function setFillInDate($fillInDate)
    {
        $this->fillInDate = \DateTime::createFromFormat('Y-m-d', $fillInDate);

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
