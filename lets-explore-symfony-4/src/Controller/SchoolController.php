<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 02/10/2018
 * Time: 13:36
 */

namespace App\Controller;

use App\Entity\School;
use App\Form\Handler\SchoolCodeFormHandler;
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
     * @Route("/minorBehavior/{schoolCode}", name="minorBehavior")
     */
    public function newMinorBehavior(School $school, Request $request, MinorAndMajorFormHandler $formHandler)
    {
        //$school = new School();

        /*
        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setSchool($school);
        $minorAndMajorBehavior->setName('');
        $minorAndMajorBehavior->setIsMinorBehavior('true');


        $school->addMinorAndMajorBehavior($minorAndMajorBehavior);
        */

        $schoolCode=$school->getSchoolCode();
        $form = $this->createForm(SchoolType::class, $school);


        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('majorBehavior', array ('schoolCode' => $schoolCode)));
        }

        return $this->render('school/new.html.twig', array(
            'form' => $form->createView(),
            'school' => $school,
            'schoolCode'=> $schoolCode,
            //'minorAndMajor' => $minorAndMajorBehavior,
            'minorNumber' => $school->countMinorBehaviors()
        ));
    }



    /**
     * @Route("/majorBehavior/{schoolCode}", name="majorBehavior")
     */
    public function newMajorBehavior(Request $request, School $school, MinorAndMajorFormHandler $formHandler)
    {


        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setName('');

        $school->addMinorAndMajorBehavior($minorAndMajorBehavior);
        $schoolCode=$school->getSchoolCode();

        $form = $this->createForm(SchoolType::class, $school);


        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('minorandmajorbehavior_list', array ('schoolCode' => $schoolCode)));
        }

        return $this->render('school/new2.html.twig', array(
            'form' => $form->createView(),
            'school' => $school,
            'minorAndMajor' => $minorAndMajorBehavior,
        ));
    }

    /**
     * @Route("/minorandmajorbehaviorlist/{schoolCode}", name="minorandmajorbehavior_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param SchoolFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(School $school) {

     $schoolCode= $school->getSchoolCode();
        $minorAndMajor = $this->getDoctrine()->getRepository('App\Entity\MinorAndMajorBehavior')->findMinMajBySchoolCode($schoolCode);
        dump($school);

        return $this->render('school/list.html.twig', array(

            'minorAndMajor' => $minorAndMajor,
        ));
    }

    /**
     * @Route("/deletebehavior/{id}", name="behavior_delete")
     * @Method({"GET"})
     *
     * @param Request $request
     * @param MinorAndMajorBehavior $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteMinorAction(Request $request, MinorAndMajorBehavior $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashbag()->add('success', 'Deleted');
        return $this->redirect($this->generateUrl('minorandmajorbehavior_list'));
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
        $schoolCode= $this->getUser()->getSchoolCode();


        $form = $this->createForm(CodeGeneratorType::class);

        if ($lastId = $formHandler->handle($form, $request, $this->getUser())) {
           // var_dump($this->getUser()->getUserId()); exit;
            //fare l'update nell'handler
            return $this->redirect($this->generateUrl('generate_access_data_number'));
        }

        $studentData = $this->getDoctrine()->getRepository('App\Entity\Student')->findStudentsBySchoolCode($schoolCode);
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
        $schoolCode= $this->getUser()->getSchoolCode();
        $studentData = $this->getDoctrine()->getRepository('App\Entity\Student')->findStudentsBySchoolCode($schoolCode);
        //dump($students);

       // $studentData = $this->getDoctrine()->getRepository('App\Entity\Student')->findAll();
        $personInChargeData = $this->getDoctrine()->getRepository('App\Entity\PersonInCharge')->findAll();

        return $this->render('school/list_of_codes.html.twig', array(
            'studentdata' => $studentData,
            'personincharge' => $personInChargeData,
        ));


    }

}