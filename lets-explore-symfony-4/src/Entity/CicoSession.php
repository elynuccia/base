<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CicoSessionRepository")
 */
class CicoSession
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $fillInDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CicoData", mappedBy="session", orphanRemoval=true, cascade={"all"})
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cico", inversedBy="sessions")
     */
    private $cico;

    public function __construct()
    {
        $this->data = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTotal()
    {
        $total = 0;

        foreach ($this->getData() as $data) {
            $total+= $data->getValue();
        }

        return $total;
    }

    public function getFillInDate()
    {
        return ($this->fillInDate instanceof \DateTime) ? $this->fillInDate->format('Y-m-d') : null;
    }

    public function setFillInDate($fillInDate)
    {
        $this->fillInDate = \DateTime::createFromFormat('Y-m-d', $fillInDate);

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
            $data->setSession($this);
        }

        return $this;
    }

    public function removeData(CicoData $data): self
    {
        if ($this->data->contains($data)) {
            $this->data->removeElement($data);
            // set the owning side to null (unless already changed)
            if ($data->getSession() === $this) {
                $data->setSession(null);
            }
        }

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
