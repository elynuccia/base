<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 11/06/18
 * Time: 10:43
 */

namespace App\Entity;
use Doctrine\Common\Collections\Collection;
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
     *@ORM\OneToMany(targetEntity="MatrixBehavior", mappedBy="matrix", cascade={"persist"})
     */
    protected $behaviorTags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cico", mappedBy="matrix", orphanRemoval=true)
     */
    private $cicos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScreeningTool", mappedBy="matrix", orphanRemoval=true)
     */
    private $screeningTools;

    public function __construct()
    {
        $this->expectationTags = new ArrayCollection();
        $this->locationTags = new ArrayCollection();
        $this->behaviorTags = new ArrayCollection();
        $this->cicos = new ArrayCollection();
        $this->screeningTools = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getLocations()
    {
        return $this->locationTags;
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

    public function removeExpectationTag(ExpectationTag $expectationTag)
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

    public function getBehaviorTags()
    {
        return $this->behaviorTags;
    }

    public function addBehaviorTag(MatrixBehavior $behaviorTag)
    {
        if(!$this->behaviorTags->contains($behaviorTag)) {
            $this->behaviorTags[] = $behaviorTag;
            $behaviorTag->setMatrix($this);

        }
    }

    public function removeBehaviorTag(MatrixBehavior $behaviorTag)
    {
        if (!$this->behaviorTags->contains($behaviorTag)) {
            $this->behaviorTags->removeElement($behaviorTag);
            if ($behaviorTag->getMatrix()=== $this) {
                $behaviorTag->setMatrix(null);
            }
        }
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
            $cico->setMatrix($this);
        }

        return $this;
    }

    public function removeCico(Cico $cico): self
    {
        if ($this->cicos->contains($cico)) {
            $this->cicos->removeElement($cico);
            // set the owning side to null (unless already changed)
            if ($cico->getMatrix() === $this) {
                $cico->setMatrix(null);
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
            $screeningTool->setMatrix($this);
        }

        return $this;
    }

    public function removeScreeningTool(ScreeningTool $screeningTool): self
    {
        if ($this->screeningTools->contains($screeningTool)) {
            $this->screeningTools->removeElement($screeningTool);
            // set the owning side to null (unless already changed)
            if ($screeningTool->getMatrix() === $this) {
                $screeningTool->setMatrix(null);
            }
        }

        return $this;
    }


}