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

class Contact
{    /**
    * @Assert\NotBlank()
    */
    protected $motto;
    /**
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     */
    protected $tags;
    protected $locationTags;



    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getMotto()
    {
        return $this->motto;
    }

    public function setMotto($motto)
    {
        $this->motto = $motto;
    }


    public function getTags()
    {
        return $this->tags;
    }
    public function addTag(Tag $tag)
    {
        // for a many-to-many association:
        $tag->addContact($this);


        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }


    public function getLocationTags()
    {
        return $this->locationTags;
    }
    public function addLocationTag(Tag $locationTag)
    {
        // for a many-to-many association:
        $locationTag->addContact($this);


        $this->locationTags->add($locationTag);
    }

    public function removeLocationTag(Tag $locationTag)
    {
        $this->locationTags->removeElement($locationTag);
    }
}