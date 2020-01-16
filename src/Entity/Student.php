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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Observation", mappedBy="student", cascade={"persist", "remove"})
     */
    private $observations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScreeningTool", mappedBy="student", cascade={"persist", "remove"})
     */
    private $screeningTools;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ODR", mappedBy="student", cascade={"persist", "remove"})
     */
    private $oDRs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\POR", mappedBy="student", cascade={"persist", "remove"})
     */
    private $pORs;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points = 0;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $schoolCode;



    public function __construct()
    {
        $this->cicos = new ArrayCollection();
        $this->schoolYears = new ArrayCollection();
        $this->screeningTools = new ArrayCollection();
        $this->oDRs = new ArrayCollection();
        $this->pORs = new ArrayCollection();
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

    /**
     * @return Collection|Observation[]
     */
    public function getObservations()
    {
        return $this->observations;
    }

    public function addObservation(Observation $observation)
    {
        if (!$this->observations->contains($observation)) {
            $this->observations[] = $observation;
            $observation->setStudent($this);
        }

        return $this;
    }

    public function removeObservation(Observation $observation)
    {
        if ($this->observations->contains($observation)) {
            $this->observations->removeElement($observation);
            // set the owning side to null (unless already changed)
            if ($observation->getStudent() === $this) {
                $observation->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ScreeningTool[]
     */
    public function getScreeningTools(): Collection
    {
        return $this->screeningTools;
    }

    public function addScreeningTool(ScreeningTool $screeningTool): self
    {
        if (!$this->screeningTools->contains($screeningTool)) {
            $this->screeningTools[] = $screeningTool;
            $screeningTool->setStudent($this);
        }

        return $this;
    }

    public function removeScreeningTool(ScreeningTool $screeningTool): self
    {
        if ($this->screeningTools->contains($screeningTool)) {
            $this->screeningTools->removeElement($screeningTool);
            // set the owning side to null (unless already changed)
            if ($screeningTool->getStudent() === $this) {
                $screeningTool->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ODR[]
     */
    public function getODRs(): Collection
    {
        return $this->oDRs;
    }

    public function addODR(ODR $oDR): self
    {
        if (!$this->oDRs->contains($oDR)) {
            $this->oDRs[] = $oDR;
            $oDR->setStudent($this);
        }

        return $this;
    }

    public function removeODR(ODR $oDR): self
    {
        if ($this->oDRs->contains($oDR)) {
            $this->oDRs->removeElement($oDR);
            // set the owning side to null (unless already changed)
            if ($oDR->getStudent() === $this) {
                $oDR->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|POR[]
     */
    public function getPORs(): Collection
    {
        return $this->pORs;
    }

    public function addPOR(POR $pOR): self
    {
        if (!$this->pORs->contains($pOR)) {
            $this->pORs[] = $pOR;
            $pOR->setStudent($this);
        }

        return $this;
    }

    public function removePOR(POR $pOR): self
    {
        if ($this->pORs->contains($pOR)) {
            $this->pORs->removeElement($pOR);
            // set the owning side to null (unless already changed)
            if ($pOR->getStudent() === $this) {
                $pOR->setStudent(null);
            }
        }

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function addPoints(?int $points): self
    {
        // dump($points);
        //dump($this->points);

        $this->points += $points;

        //dump($this->points);

        return $this;
    }

    public function subPoints(?int $points): self
    {
        //dump($points);
        //dump($this->points);

        if($this->point) {
            $this->points -= $points;
        }

        //dump($this->points);

        return $this;
    }

    public function getSchoolCode(): ?string
    {
        return $this->schoolCode;
    }

    public function setSchoolCode(?string $schoolCode): self
    {
        $this->schoolCode = $schoolCode;

        return $this;
    }


}
