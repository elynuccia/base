<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 04/07/18
 * Time: 13:15
 */

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatrixBehaviorRepository")
 */
class MatrixBehavior
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *@ORM\ManyToOne(targetEntity="Matrix", inversedBy="behaviorTags")
     */
    protected $matrix;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     *
     */

    protected $behavior;

    /**
     *@ORM\ManyToOne(targetEntity="ExpectationTag")
     */
    protected $expectation;

    /**
     *@ORM\ManyToOne(targetEntity="LocationTag")
     */
    protected $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\POR", mappedBy="positiveBehaviors")
     */
    private $pORs;

    public function __construct()
    {
        $this->pORs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMatrix()
    {
        return $this->matrix;
    }

    /**
     * @param mixed $matrix
     */
    public function setMatrix($matrix): void
    {
        $this->matrix = $matrix;
    }

    /**
     * @return mixed
     */
    public function getBehavior()
    {
        return $this->behavior;
    }

    /**
     * @param mixed $behavior
     */
    public function setBehavior($behavior): void
    {
        $this->behavior = $behavior;
    }

    /**
     * @return mixed
     */
    public function getExpectation()
    {
        return $this->expectation;
    }

    /**
     * @param mixed $expectation
     */
    public function setExpectation($expectation)
    {
        $this->expectation = $expectation;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
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
            $pOR->addPositiveBehavior($this);
        }

        return $this;
    }

    public function removePOR(POR $pOR): self
    {
        if ($this->pORs->contains($pOR)) {
            $this->pORs->removeElement($pOR);
            $pOR->removePositiveBehavior($this);
        }

        return $this;
    }



}