<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cico", mappedBy="student", orphanRemoval=true)
     */
    private $cicos;

    public function __construct()
    {
        $this->cicos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Cico[]
     */
    public function getCicos(): Collection
    {
        return $this->cicos;
    }

    public function addCico(Cico $cico): self
    {
        if (!$this->cicos->contains($cico)) {
            $this->cicos[] = $cico;
            $cico->setStudent($this);
        }

        return $this;
    }

    public function removeCico(Cico $cico): self
    {
        if ($this->cicos->contains($cico)) {
            $this->cicos->removeElement($cico);
            // set the owning side to null (unless already changed)
            if ($cico->getStudent() === $this) {
                $cico->setStudent(null);
            }
        }

        return $this;
    }
}
