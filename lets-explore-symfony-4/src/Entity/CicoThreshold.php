<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CicoThresholdRepository")
 */
class CicoThreshold
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
    private $threshold;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cico", inversedBy="cicoThresholds")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cico;

    //calcolo delle soglie percentuali in punti
    public function getThresholdInPoints()
    {
        $total = $this->cico->getPeriodNumber() * $this->cico->getMatrix()->getExpectationTags()->count() * 3;

        return $this->threshold * $total / 100;
    }

    public function getId()
    {
        return $this->id;
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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getCico(): ?Cico
    {
        return $this->cico;
    }

    public function setCico(?Cico $cico): self
    {
        $this->cico = $cico;

        return $this;
    }
}
