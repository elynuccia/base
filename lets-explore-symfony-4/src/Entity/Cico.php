<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CicoRepository")
 */
class Cico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $periodNumber;

    /**
     * @ORM\Column(type="integer")
     */
    private $threshold;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Matrix", inversedBy="cicos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matrix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="cicos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $student;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CicoData", mappedBy="cico", orphanRemoval=true)
     */
    private $data;

    public function __construct()
    {
        $this->data = new ArrayCollection();

    }

    public function getId()
    {
        return $this->id;
    }

    public function getPeriodNumber(): ?int
    {
        return $this->periodNumber;
    }

    public function setPeriodNumber(int $periodNumber): self
    {
        $this->periodNumber = $periodNumber;

        return $this;
    }

    public function getThreshold(): ?int
    {
        return $this->threshold;
    }

    public function setThreshold(int $threshold): self
    {
        $this->threshold = $threshold;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    /**
     * @return Collection|CicoData[]
     */
    public function getData(): Collection
    {
        return $this->data;
    }

    public function addData(CicoData $data): self
    {
        if (!$this->data->contains($data)) {
            $this->data[] = $data;
            $data->setCico($this);
        }

        return $this;
    }

    public function removeData(CicoData $data): self
    {
        if ($this->data->contains($data)) {
            $this->data->removeElement($data);
            // set the owning side to null (unless already changed)
            if ($data->getCico() === $this) {
                $data->setCico(null);
            }
        }

        return $this;
    }
}
