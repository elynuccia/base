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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tmpData;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CicoSession", mappedBy="cico", cascade={"all"})
     */
    private $sessions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CicoThreshold", mappedBy="cico", cascade={"all"}, orphanRemoval=true)
     */
    private $cicoThresholds;



    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->cicoThresholds = new ArrayCollection();

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

    public function getTmpData(): ?string
    {
        return $this->tmpData;
    }

    public function setTmpData(?string $tmpData): self
    {
        $this->tmpData = $tmpData;

        return $this;
    }

    /**
     * @return Collection|CicoSession[]
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(CicoSession $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCico($this);
        }

        return $this;
    }

    public function removeSession(CicoSession $session): self
    {
        if ($this->sessions->contains($session)) {
            $this->sessions->removeElement($session);
            // set the owning side to null (unless already changed)
            if ($session->getCico() === $this) {
                $session->setCico(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CicoThreshold[]
     */
    public function getCicoThresholds(): Collection
    {
        return $this->cicoThresholds;
    }

    public function addCicoThreshold(CicoThreshold $cicoThreshold): self
    {
        if (!$this->cicoThresholds->contains($cicoThreshold)) {
            $this->cicoThresholds[] = $cicoThreshold;
            $cicoThreshold->setCico($this);
        }

        return $this;
    }

    public function removeCicoThreshold(CicoThreshold $cicoThreshold): self
    {
        if ($this->cicoThresholds->contains($cicoThreshold)) {
            $this->cicoThresholds->removeElement($cicoThreshold);
            // set the owning side to null (unless already changed)
            if ($cicoThreshold->getCico() === $this) {
                $cicoThreshold->setCico(null);
            }
        }

        return $this;
    }

}
