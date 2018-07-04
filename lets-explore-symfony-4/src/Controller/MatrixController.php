<?php

namespace App\Controller;

use App\Form\Type\MatrixType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use App\Entity\Matrix;
use App\Form\Type\TaskType;
use Doctrine\Common\Collections\ArrayCollection;

class MatrixController extends AbstractController
{
    /**
     * @Route("/matrix", name="matrix")
     */
    public function index(Request $request)
    {
        $contact = new Matrix();
/*
        $tag3 = new Tag();
        $tag3->setName('tag3');
        $matrix->getTags()->add($tag3);

        $tag4=new Tag();
        $tag4->setName('ciao');
        $matrix->getTags()->add($tag4);*/

        $form = $this->createForm(MatrixType::class, $contact);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            dump($contactFormData);
        }

        return $this->render('matrix/index.html.twig', array(
            //'our_form' => $form,
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
            return $this->redirectToRoute('matrix', array('id' => $id));
        }

        // render some form template
    }


}
