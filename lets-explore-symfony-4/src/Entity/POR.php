<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PORRepository")
 */
class POR
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MatrixBehavior", inversedBy="pORs")
     */
    private $positiveBehaviors;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LocationTag", inversedBy="pORs")
     */
    private $locations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fillInDate;

    public function __construct()
    {
        $this->positiveBehaviors = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|MatrixBehavior[]
     */
    public function getPositiveBehaviors(): Collection
    {
        return $this->positiveBehaviors;
    }

    public function addPositiveBehavior(MatrixBehavior $positiveBehavior): self
    {
        if (!$this->positiveBehaviors->contains($positiveBehavior)) {
            $this->positiveBehaviors[] = $positiveBehavior;
        }

        return $this;
    }

    public function removePositiveBehavior(MatrixBehavior $positiveBehavior): self
    {
        if ($this->positiveBehaviors->contains($positiveBehavior)) {
            $this->positiveBehaviors->removeElement($positiveBehavior);
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
}
