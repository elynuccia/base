<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 11/06/18
 * Time: 10:43
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 */
class Matrix
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    protected $motto;
    /**
     * @ORM\ManyToMany(targetEntity="App/Entity/Tag", cascade={"persist"})
     */
    protected $expectationTags;
    /**
     *@ORM\ManyToMany(targetEntity="App/Entity/Tag", cascade={"persist"})
     */
    protected $locationTags;

    /**
     *@ORM\OneToMany(targetEntity="App/Entity/MatrixBehavior", mappedBy="Matrix")
     */
    protected $behaviors;



    public function __construct()
    {
        $this->expectationTags = new ArrayCollection();
        $this->locationTags = new ArrayCollection();
        $this->behaviorTags = new ArrayCollection();
    }


    public function getMotto()
    {
        return $this->motto;
    }

    public function setMotto($motto)
    {
        $this->motto = $motto;
    }


    public function getExpectationTags()
    {
        return $this->expectationTags;
    }
    public function addExpectationTag(Tag $expectationTag)
    {
        // for a many-to-many association:
        $expectationTag->addMatrix($this);


        $this->expectationTags->add($expectationTag);
    }

    public function removeTag(Tag $expectationTag)
    {
        $this->expectationTags->removeElement($expectationTag);
    }


    public function getLocationTags()
    {
        return $this->locationTags;
    }
    public function addLocationTag(Tag $locationTag)
    {
        // for a many-to-many association:
        $locationTag->addMatrix($this);


        $this->locationTags->add($locationTag);
    }

    public function removeLocationTag(Tag $locationTag)
    {
        $this->locationTags->removeElement($locationTag);
    }

/*
    public function getBehaviorTags()
    {
        return $this->behaviorTags;
    }
    public function addBehaviorTags(Tag $behaviorTags)
    {
        // for a many-to-many association:
        $behaviorTags->addContact($this);


        $this->behaviorTags->add($behaviorTags);
    }

    public function removeBehaviorTags(Tag $behaviorTags)
    {
        $this->behaviorTags->removeElement($behaviorTags);
    }*/
}