<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 26/11/2018
 * Time: 12:39
 */

namespace App\Controller;

use App\Utility\SchoolAccessDataGenerator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\School;
use App\Entity\Administrator;
use App\Form\Handler\SchoolFormHandler;
use App\Form\Type\SchoolType;
use App\Form\Type\AdministratorType;
use Symfony\Component\HttpFoundation\Request;
use App\Utility\AccessDataGenerator;




class FrontendController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function newRegistration(Request $request, SchoolFormHandler $formHandler)
    {
        $school=new School();

        $form = $this->createForm(SchoolType::class, $school);

        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('school_registration', array ()));
        }

        return $this->render('frontend/new.html.twig', array(
            'form' => $form->createView(),

        ));
    }



    /**
     * @Route("/schoolregistration", name="school_registration")
     */
    public function index(Request $request, SchoolAccessDataGenerator $schoolAccessDataGenerator)
    {
        //$accessData= $schoolAccessDataGenerator->generateCode();
        //bisogna aggiungere code su school e generare un codice
        return $this->render('frontend/index.html.twig', array(
            // 'accessData'=> $accessData,
        ));

    }
}