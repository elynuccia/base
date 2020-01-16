<?php
namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 */
class LocationTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Matrix", inversedBy="locationTags")
     */
    private $matrix;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ODR", mappedBy="locations")
     */
    private $oDRs;

    public function __construct()
    {
        $this->oDRs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getMatrix()
    {
        return $this->matrix;
    }

    public function setMatrix($matrix)
    {
        $this->matrix = $matrix;
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
            $oDR->addLocation($this);
        }

        return $this;
    }

    public function removeODR(ODR $oDR): self
    {
        if ($this->oDRs->contains($oDR)) {
            $this->oDRs->removeElement($oDR);
            $oDR->removeLocation($this);
        }

        return $this;
    }
}
