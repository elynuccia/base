<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student implements UserInterface
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
     * @ORM\Column(type="string", length=128, unique=true)
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PersonInCharge", mappedBy="student", cascade={"persist", "remove"})
     */
    private $personInCharge;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $teacherCoordinator;

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


    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }


    public function getPersonInCharge(): ?PersonInCharge
    {
        return $this->personInCharge;
    }

    public function setPersonInCharge(PersonInCharge $personInCharge): self
    {
        $this->personInCharge = $personInCharge;

        // set the owning side of the relation if necessary
        if ($this !== $personInCharge->getStudent()) {
            $personInCharge->setStudent($this);
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->code;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_STUDENT';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTeacherCoordinator(): ?string
    {
        return $this->teacherCoordinator;
    }

    public function setTeacherCoordinator(?string $teacherCoordinator): self
    {
        $this->teacherCoordinator = $teacherCoordinator;

        return $this;
    }
}
