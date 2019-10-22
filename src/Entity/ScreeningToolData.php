<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScreeningToolDataRepository")
 */
class ScreeningToolData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ScreeningTool", inversedBy="screeningToolData", cascade={"all"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $screeningTool;

    /**
     * @ORM\Column(type="integer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ExpectationTag")
     * @ORM\JoinColumn(nullable=false)
     */
    private $expectation;

    public function getId()
    {
        return $this->id;
    }

    public function getScreeningTool(): ?ScreeningTool
    {
        return $this->screeningTool;
    }

    public function setScreeningTool(?ScreeningTool $screeningTool): self
    {
        $this->screeningTool = $screeningTool;

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

    public function getExpectation(): ?ExpectationTag
    {
        return $this->expectation;
    }

    public function setExpectation(?ExpectationTag $expectation): self
    {
        $this->expectation = $expectation;

        return $this;
    }
}
