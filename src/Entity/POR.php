<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $fillInDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="pORs")
     */
    private $student;

    public function __construct()
    {
        $this->positiveBehaviors = new ArrayCollection();
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
