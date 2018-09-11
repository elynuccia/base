<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CicoDataRepository")
 */
class CicoData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cico", inversedBy="data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cico;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExpectationTag")
     * @ORM\JoinColumn(nullable=false)
     */
    private $expectation;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="date")
     */
    private $fillInDate;

    public function getId()
    {
        return $this->id;
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

    public function getExpectation(): ?ExpectationTag
    {
        return $this->expectation;
    }

    public function setExpectation(?ExpectationTag $expectation): self
    {
        $this->expectation = $expectation;

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

    public function getFillInDate(): ?\DateTimeInterface
    {
        return $this->fillInDate;
    }

    public function setFillInDate(\DateTimeInterface $fillInDate): self
    {
        $this->fillInDate = $fillInDate;

        return $this;
    }
}
