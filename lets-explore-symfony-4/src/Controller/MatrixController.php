<?php

namespace App\Controller;

use App\Entity\BehaviorTag;
use App\Entity\ExpectationTag;
use App\Entity\LocationTag;
use App\Entity\MatrixBehavior;
use App\Form\Type\MatrixType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Task;
use App\Entity\Matrix;
use App\Form\Handler\MatrixFormHandler;
use App\Form\Type\TaskType;
use Doctrine\Common\Collections\ArrayCollection;

class MatrixController extends AbstractController
{
    /**
     * @Route("/matrix", name="matrix")
     * @Method({"GET", "POST"})
     */
    public function index(Request $request, MatrixFormHandler $formHandler)
    {
        $matrix = new Matrix();

        /* $tag1 = new BehaviorTag();

         $tag1->setName('tag1');
         $matrix->getBehaviorTags()->add($tag1);*/


        $form = $this->createForm(MatrixType::class, $matrix);

        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('matrix_behavior_new', array('id' => $lastId)));
        }


        return $this->render('matrix/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
/*
    public function edit($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $matrix = $entityManager->getRepository(Matrix::class)->find($id);

        if (!$matrix) {
            throw $this->createNotFoundException('No task found for id ' . $id);
        }

        $originalTags = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($matrix->getExpectationTags() as $expectationTag) {
            $originalTags->add($expectationTag);
        }

        foreach ($matrix->getLocationTags() as $locationTag) {
            $originalTags->add($locationTag);
        }

        $editForm = $this->createForm(TaskType::class, $matrix);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            // remove the relationship between the tag and the Task
            foreach ($originalTags as $expectationTag) {
                if (false === $matrix->getExpectationTags()->contains($expectationTag)) {


                    // if it was a many-to-one relationship, remove the relationship like this
                    $expectationTag->setExpectationTask(null);

                    $entityManager->persist($expectationTag);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $entityManager->remove($tag);
                }
            }
            foreach ($originalTags as $locationTag) {
                if (false === $matrix->getLocationTags()->contains($locationTag)) {


                    // if it was a many-to-one relationship, remove the relationship like this
                    $locationTag->setTask(null);

                    $entityManager->persist($locationTag);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $entityManager->remove($tag);
                }
            }
            $entityManager->persist($matrix);
            $entityManager->flush();

            // redirect back to some edit page
            return $this->redirectToRoute('matrix', array('id' => $id));
        }

        // render some form template
        $matrix = new Matrix();


        $form = $this->createForm(MatrixType::class, $matrix);


        return $this->render('matrix/index.html.twig', array(
            //'our_form' => $form,
            'form' => $form->createView(),
        ));

    }*/

    /**
     * @Route("/behavior/{id}", name="matrix_behavior_new")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param MatrixFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Matrix $matrix, MatrixFormHandler $formHandler)
    {
        foreach ($matrix->getLocationTags() as $location) {
            foreach ($matrix->getExpectationTags() as $expectation) {
                $matrixBehavior = new MatrixBehavior();
                $matrixBehavior->setLocation($location);

                $matrixBehavior->setExpectation($expectation);

                $matrix->addBehaviorTag($matrixBehavior);

            }

        }


        dump($matrix);

        $form = $this->createForm(MatrixType::class, $matrix, array(
            'matrix' => $matrix,
            'action' => $this->generateUrl('matrix_behavior_new', array(
                'id' => $matrix->getId()
            ))
        ));
        dump($form);

        // per la visualizzazione
        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('matrix_list', array('id' => $lastId)));
        }

        return $this->render('matrix/new.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $matrix,

        ));
    }

    /**
     * @Route("/list/{id}", name="matrix_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param MatrixFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, Matrix $matrix, MatrixFormHandler $formHandler) {

        $form = $this->createForm(MatrixType::class, $matrix, array(
            'matrix' => $matrix,
            ));


        return $this->render('matrix/list.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $matrix,
        ));
    }

    /**
     * @Route("/behaviors", name="matrix_behavior_list")
     * @Method({"GET"})
     * @Template
     *
     * @param Request $request
     * @param MatrixFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBehaviorsByExpectationAndLocationAction(ExpectationTag $expectationTag,
                                                               LocationTag $locationTag)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $matrixBehaviors = $entityManager->getRepository(MatrixBehavior::class)
            ->findByExpectationAndLocation($expectationTag, $locationTag);

        return array('behaviors' => $matrixBehaviors);
    }
}
