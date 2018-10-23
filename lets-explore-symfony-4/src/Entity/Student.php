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
     * @ORM\Column(type="string", length=8, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $qrCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cico", mappedBy="student", orphanRemoval=true)
     */
    private $cicos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SchoolYear", mappedBy="students")
     */
    private $schoolYears;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $personInChargeCode;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="text")
     */
    private $personInChargeQrCode;

    public function __construct()
    {
        $this->cicos = new ArrayCollection();
        $this->schoolYears = new ArrayCollection();
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

    public function getQrCode(): ?string
    {
        return $this->qrCode;
    }

    public function setQrCode(string $qrCode): self
    {
        $this->qrCode = $qrCode;

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

    /**
     * @return Collection|SchoolYear[]
     */
    public function getSchoolYears(): Collection
    {
        return $this->schoolYears;
    }

    public function addSchoolYear(SchoolYear $schoolYear): self
    {
        if (!$this->schoolYears->contains($schoolYear)) {
            $this->schoolYears[] = $schoolYear;
            $schoolYear->addStudent($this);
        }

        return $this;
    }

    public function removeSchoolYear(SchoolYear $schoolYear): self
    {
        if ($this->schoolYears->contains($schoolYear)) {
            $this->schoolYears->removeElement($schoolYear);
            $schoolYear->removeStudent($this);
        }

        return $this;
    }

    public function getPersonInChargeCode(): ?string
    {
        return $this->personInChargeCode;
    }

    public function setPersonInChargeCode(string $personInChargeCode): self
    {
        $this->personInChargeCode = $personInChargeCode;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getPersonInChargeQrCode(): ?string
    {
        return $this->personInChargeQrCode;
    }

    public function setPersonInChargeQrCode(string $personInChargeQrCode): self
    {
        $this->personInChargeQrCode = $personInChargeQrCode;

        return $this;
    }
}
