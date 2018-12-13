<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 26/11/2018
 * Time: 12:39
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\School;
use App\Form\Handler\SchoolFormHandler;
use App\Form\Type\SchoolType;
use Symfony\Component\HttpFoundation\Request;




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
            'school'=>$school,
            'admin'=>$school->getAdministrator(),
            'code' => $school->getCode(),

        ));
    }



    /**
     * @Route("/schoolregistration", name="school_registration")
     */
    public function index(Request $request)
    {

        return $this->render('frontend/index.html.twig', array(
            // 'accessData'=> $accessData,
        ));

    }
}