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
     *@ORM\ManyToOne(targetEntity="LocationTag")
     */
    protected $location;

}