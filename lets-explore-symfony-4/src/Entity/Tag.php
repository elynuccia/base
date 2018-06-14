<?php
namespace App\Entity;

class Tag
{
    private $name;


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

    public function addContact(Contact $contacts)
    {
        if (!$this->tasks->contains($contacts)) {
            $this->tasks->add($contacts);
        }
    }
}
