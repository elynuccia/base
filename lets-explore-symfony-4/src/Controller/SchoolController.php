<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 02/10/2018
 * Time: 13:36
 */

namespace App\Controller;

use App\Entity\School;
use App\Entity\MinorAndMajorBehavior;
use App\Form\Handler\SchoolFormHandler;
use App\Form\Type\SchoolType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SchoolController extends AbstractController
{

    /**
     * @Route("/minorBehavior/", name="minorBehavior")
     */
    public function newMinorBehavior(Request $request, SchoolFormHandler$formHandler)
    {
        $school = new School();

        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setName('min1');
        $minorAndMajorBehavior->setIsMinorBehavior('true');

        $minorAndMajorBehavior->setSchool($school);

        $school->addMinorAndMajorBehavior($minorAndMajorBehavior);

        $form = $this->createForm(SchoolType::class, $school);


        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('majorBehavior', array ('id' => $lastId)));
        }

        return $this->render('school/new.html.twig', array(
            'form' => $form->createView(),
        ));    }



    /**
     * @Route("/majorBehavior/{id}", name="majorBehavior")
     */
    public function newMajorBehavior(Request $request, School $school, SchoolFormHandler $formHandler)
    {


        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setName('maj1');

        $school->addMinorAndMajorBehavior($minorAndMajorBehavior);

        $form = $this->createForm(SchoolType::class, $school);


        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('minorandmajorbehavior_list'));
        }

        return $this->render('school/new2.html.twig', array(
            'form' => $form->createView(),
            'school' => $school,
        ));
    }

    /**
     * @Route("/minorandmajorbehaviorlist", name="minorandmajorbehavior_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param SchoolFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction() {


        $minorAndMajor = $this->getDoctrine()->getRepository('App\Entity\MinorAndMajorBehavior')->findAll();


        return $this->render('school/list.html.twig', array(

            'minorAndMajor' => $minorAndMajor,
        ));
    }
}