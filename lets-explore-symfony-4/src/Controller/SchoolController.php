<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 02/10/2018
 * Time: 13:36
 */

namespace App\Controller;

use App\Entity\School;
use App\Utility\Auth0Api;
use App\Entity\MinorAndMajorBehavior;
use App\Form\Handler\MinorAndMajorFormHandler;
use App\Form\Handler\SchoolFormHandler;
use App\Form\Handler\CodeGeneratorFormHandler;
use App\Form\Type\SchoolType;
use App\Form\Type\CodeGeneratorType;
use App\Utility\AccessDataGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SchoolController extends AbstractController
{

    /**
     * @Route("/minorBehavior/{id}", name="minorBehavior")
     */
    public function newMinorBehavior(School $school, Request $request, MinorAndMajorFormHandler $formHandler)
    {
        //$school = new School();

        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setSchool($school);
        $minorAndMajorBehavior->setName('minor');
        $minorAndMajorBehavior->setIsMinorBehavior('true');


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
    public function newMajorBehavior(Request $request, School $school, MinorAndMajorFormHandler $formHandler)
    {


        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setName('major');

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


    /**
     * @Route("/generateaccessdata/{id}", name="generate_access_data")
     * @Template
     */
    public function generateAccessDataAction(Request $request, School $school, Auth0Api $auth0Api, CodeGeneratorFormHandler $formHandler, AccessDataGenerator $accessDataGenerator)
    {


        /*   if ($lastId = $formHandler->handle($form, $request)) {
               return $this->redirect($this->generateUrl('majorBehavior', array ('id' => $lastId)));
           }
*/
       $user = $this->getUser();

        $form = $this->createForm(CodeGeneratorType::class);

        if ($lastId = $formHandler->handle($form, $request, $this->getUser())) {
           // var_dump($this->getUser()->getUserId()); exit;
            //fare l'update nell'handler
            return $this->redirect($this->generateUrl('generate_access_data_number'));
        }

        $studentData = $this->getDoctrine()->getRepository('App\Entity\Student')->findAll();
        $personInChargeData = $this->getDoctrine()->getRepository('App\Entity\PersonInCharge')->findAll();


        return $this->render('school/generate_access_data.html.twig', array(
            'form' => $form->createView(),
            'school'=> $school,
            'studentdata' => $studentData,
            'personincharge' => $personInChargeData,
            'user' => $user,
        ));


    }


    /**
     * @Route("/generateaccessdatanumber", name="generate_access_data_number")
     * @Template
     */
    public function generateAccessDataByNumberAction(AccessDataGenerator $accessDataGenerator)
    {
        //$accessData = $accessDataGenerator->generateAccessData($number);
        /*   if ($lastId = $formHandler->handle($form, $request)) {
               return $this->redirect($this->generateUrl('majorBehavior', array ('id' => $lastId)));
           }
*/

        $studentData = $this->getDoctrine()->getRepository('App\Entity\Student')->findAll();
        $personInChargeData = $this->getDoctrine()->getRepository('App\Entity\PersonInCharge')->findAll();

        return $this->render('school/list_of_codes.html.twig', array(
            'studentdata' => $studentData,
            'personincharge' => $personInChargeData,
        ));


    }

}