<?php
namespace App\Controller;

use App\Entity\Task;
use App\Entity\Tag;
use App\Form\Type\TaskType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;


class TaskController extends Controller
{
    /**
    * @Route("/task", name="task")
     */
    public function new(Request $request)
    {
        $task = new Task();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $tag1 = new Tag();
        $tag1->setName('tag1');
        $task->getTags()->add($tag1);
        $tag2 = new Tag();
        $tag2->setName('tag2');
        $task->getTags()->add($tag2);
        // end dummy code

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            //dump($contactFormData);
            //
              }

        return $this->render('task/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function edit($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);

        if (!$task) {
            throw $this->createNotFoundException('No task found for id '.$id);
        }

        $originalTags = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($task->getTags() as $tag) {
            $originalTags->add($tag);
        }

        $editForm = $this->createForm(TaskType::class, $task);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            // remove the relationship between the tag and the Task
            foreach ($originalTags as $tag) {
                if (false === $task->getTags()->contains($tag)) {
                    // remove the Task from the Tag
                    $tag->getTasks()->removeElement($task);

                    // if it was a many-to-one relationship, remove the relationship like this
                    // $tag->setTask(null);

                    $entityManager->persist($tag);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $entityManager->remove($tag);
                }
            }

            $entityManager->persist($task);
            $entityManager->flush();

            // redirect back to some edit page
            return $this->redirectToRoute('task', array('id' => $id));
        }

        // render some form template
    }
}