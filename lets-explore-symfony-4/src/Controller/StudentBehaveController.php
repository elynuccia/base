<?php

namespace App\Controller;

use App\Entity\StudentBehave;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;

use App\Form\Handler\StudentBehaveFormHandler;
use App\Form\Type\StudentBehaveType;

/**
 * @Route("/student")
 *
 * Class StudentBehaveController
 * @package App\Controller
 */
class StudentBehaveController extends Controller
{
    CONST NEW_SUCCESS_STRING = 'Student inserted successfully';
    CONST EDIT_SUCCESS_STRING = 'Student edited successfully';
    CONST DELETE_SUCCESS_STRING = 'Student deleted successfully';
    CONST NEW_TITLE = 'Insert new student';
    CONST EDIT_TITLE = 'Edit student';
    CONST INDEX_TITLE = 'List of students';

    /**
     * @Route("/list", name="student_list")
     * @Method({"GET"})
     * @Template
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $records = $this->getDoctrine()->getRepository('App\Entity\StudentBehave')->findAll();


        return array(
            'records' => $records,
            'title' => $this->get('translator')->trans(self::INDEX_TITLE)
        );
    }

    /**
    * @Route("/edit/{id}", name="student_edit")
    * @Method({"GET", "POST"})  
    *
    * @param Request $request
    * @param StudentBehave $studentBehave
    * @param StudentBehaveFormHandler $formHandler
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function editAction(Request $request, StudentBehave $studentBehave, StudentBehaveFormHandler $formHandler)
    {
        $form = $this->createForm(StudentBehaveType::class, $studentBehave, array(
            'action' => $this->generateUrl('student_edit', array('id' => $studentBehave->getId())),
        ));

        if($formHandler->handle($form, $request, $this->get('translator')->trans(self::EDIT_SUCCESS_STRING))) {
            return $this->redirect($this->generateUrl('student_list'));
        }

        return $this->render('student_behave/new.html.twig',
            array(
                'form' => $form->createView(),
                'title' => $this->get('translator')->trans(self::EDIT_TITLE),
                'actionName' => 'Edit'
            )
        );
    }

    /**
    * @Route("/new", name="student_new")
    * @Method({"GET", "POST"})
    * @Template
    *
    * @param Request $request
    * @param StudentBehaveFormHandler $formHandler
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function newAction(Request $request, StudentBehaveFormHandler $formHandler)
    {
        $entity = new StudentBehave();
        $entity->setCreatorUserId($this->getUser()->getUserId());

        $form = $this->createForm(StudentBehaveType::class, $entity, array(
            'action' => $this->generateUrl('student_new')
        ));

        if($formHandler->handle($form, $request, $this->get('translator')->trans(self::NEW_SUCCESS_STRING))) {
            return $this->redirect($this->generateUrl('student_list'));
        }

        return array(
            'form' => $form->createView(),
            'title' => $this->get('translator')->trans(self::NEW_TITLE),
            'actionName' => 'New'
        );

    }

    /**
    * @Route("/delete/{id}", name="student_delete")
    * @Method({"GET"})
    *
    * @param Request $request
    * @param StudentBehave $entity
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function deleteAction(Request $request, StudentBehave $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashbag()->add('success', $this->get('translator')->trans(self::DELETE_SUCCESS_STRING));

        return $this->redirect($this->generateUrl('student_list'));
    }
}