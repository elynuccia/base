<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

class Tag
{
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Task", cascade={"persist"})
     */
    private $tasks;

    /**
     * @ORM\ManyToMany(targetEntity="Matrix", cascade={"persist"})
     */
    private $matrixes;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->matrixes = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function addTask(Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
        }
    }

    public function addMatrix(Matrix $matrix)
    {
        if (!$this->matrixes->contains($matrix)) {
            $this->matrixes->add($matrix);
        }
    }
}
