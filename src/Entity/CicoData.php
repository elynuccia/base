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
     * @ORM\ManyToOne(targetEntity="App\Entity\ExpectationTag")
     * @ORM\JoinColumn(nullable=false)
     */
    private $expectation;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CicoSession", inversedBy="data")
     * @ORM\JoinColumn(nullable=false)
     */
    private $session;

    public function getId()
    {
        return $this->id;
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

    public function getSession(): ?CicoSession
    {
        return $this->session;
    }

    public function setSession(?CicoSession $session): self
    {
        $this->session = $session;

        return $this;
    }
}
