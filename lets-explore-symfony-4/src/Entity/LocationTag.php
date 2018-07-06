<?php
namespace App\Entity;

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

    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Matrix", inversedBy="locationTags")
     */
    private $matrix;

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


}
