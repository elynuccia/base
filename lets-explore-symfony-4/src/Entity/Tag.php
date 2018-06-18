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
     * @ORM\ManyToMany(targetEntity="Contact", cascade={"persist"})
     */
    private $contacts;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->contacts = new ArrayCollection();
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

    public function addContact(Contact $contact)
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }
    }
}
