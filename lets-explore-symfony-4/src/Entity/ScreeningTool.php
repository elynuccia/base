<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScreeningToolRepository")
 */
class ScreeningTool
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matrix", inversedBy="screeningTools")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matrix;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScreeningToolData", mappedBy="screeningTool", orphanRemoval=true, cascade={"all"})
     */
    private $screeningToolData;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="screeningTools")
     */
    private $student;

    public function __construct()
    {
        $this->screeningToolData = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMatrix(): ?Matrix
    {
        return $this->matrix;
    }

    public function setMatrix(?Matrix $matrix): self
    {
        $this->matrix = $matrix;

        return $this;
    }


    /**
     * @return Collection|ScreeningToolData[]
     */
    public function getScreeningToolData(): Collection
    {
        return $this->screeningToolData;
    }

    public function addScreeningToolData(ScreeningToolData $screeningToolData): self
    {
        if (!$this->screeningToolData->contains($screeningToolData)) {
            $this->screeningToolData[] = $screeningToolData;
            $screeningToolData->setScreeningTool($this);
        }

        return $this;
    }

    public function removeScreeningToolData(ScreeningToolData $screeningToolData): self
    {
        if ($this->screeningToolData->contains($screeningToolData)) {
            $this->screeningToolData->removeElement($screeningToolData);
            // set the owning side to null (unless already changed)
            if ($screeningToolData->getScreeningTool() === $this) {
                $screeningToolData->setScreeningTool(null);
            }
        }

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
