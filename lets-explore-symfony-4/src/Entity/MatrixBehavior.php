<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 04/07/18
 * Time: 13:15
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
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
     *@ORM\ManyToOne(targetEntity="Matrix", inversedBy="behaviors")
     */
    protected $matrix;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    protected $behavior;

    /**
     *@ORM\ManyToOne(targetEntity="ExpectationTag")
     */
    protected $expectation;

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
    public function setExpectation($expectation): void
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
     *@ORM\ManyToOne(targetEntity="LocationTag")
     */
    protected $location;

}