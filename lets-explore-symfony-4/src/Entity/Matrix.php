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
     * @ORM\OneToMany(targetEntity="ExpectationTag", mappedBy="matrix", cascade={"persist"})
     */
    protected $expectationTags;
    /**
     *@ORM\OneToMany(targetEntity="LocationTag", mappedBy="matrix", cascade={"persist"})
     */
    protected $locationTags;

    /**
     *@ORM\OneToMany(targetEntity="MatrixBehavior", mappedBy="matrix")
     */
    protected $behaviors;



    public function __construct()
    {
        $this->expectationTags = new ArrayCollection();
        $this->locationTags = new ArrayCollection();
        $this->behaviorTags = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
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

    public function addExpectationTag(ExpectationTag $expectationTag)
    {
      if(!$this->expectationTags->contains($expectationTag)) {
          $this->expectationTags[] = $expectationTag;
          $expectationTag->setMatrix($this);

      }
    }

    public function removeTag(ExpectationTag $expectationTag)
    {
        if (!$this->expectationTags->contains($expectationTag)) {
            $this->expectationTags->removeElement($expectationTag);
            if ($expectationTag->getMatrix()=== $this) {
                $expectationTag->setMatrix(null);
            }
        }
    }


    public function getLocationTags()
    {
        return $this->locationTags;
    }
    public function addLocationTag(LocationTag $locationTag)
    {
        if(!$this->locationTags->contains($locationTag)) {
            $this->locationTags[] = $locationTag;
            $locationTag->setMatrix($this);

        }
    }

    public function removeLocationTag(LocationTag $locationTag)
    {
        if (!$this->locationTags->contains($locationTag)) {
            $this->locationTags->removeElement($locationTag);
            if ($locationTag->getMatrix()=== $this) {
                $locationTag->setMatrix(null);
            }
        }
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