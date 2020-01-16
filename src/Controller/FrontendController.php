<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 26/11/2018
 * Time: 12:39
 */

namespace App\Controller;

use GuzzleHttp\Exception\ClientException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\School;
use App\Form\Handler\SchoolFormHandler;
use App\Form\Handler\SchoolCodeFormHandler;
use App\Form\Type\SchoolType;
use App\Form\Type\SchoolCodeType;
use Symfony\Component\HttpFoundation\Request;

use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Response;


class FrontendController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request, GuzzleClient $guzzleClient)
    {
        $client = new GuzzleClient([
            'base_uri' => 'http://localhost:8000',
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        $response = $guzzleClient->post('http://localhost:8000/codelogin', array(
            'form_params' => array(
                'code' => '01B8B7D1'
            ),
            'verify' => false
            ));


        return $this->redirect($this->generateUrl('welcome'));

           /* $guzzleClient->post($this->generateUrl('app_login', array(), UrlGeneratorInterface::ABSOLUTE_URL), array(
                'form_params' => array(
                    'code' => '01B8B7D1'
                )
            ));




        return $this->redirect($this->generateUrl('welcome'));
           */
    }


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


    /**
     * @Route("/schoolcode", name="school_code")
     * @Method({"GET", "POST"})
     */
    public function schoolCodeIndex(Request $request, SchoolCodeFormHandler $formHandler)
    {
        if($this->getUser()->getSchoolCode() && !in_array('ROLE_USER_SCHOOLS_COORDINATOR', $this->getUser()->getRoles())) {
            return new Response('You have not the right to access this page', 403);
        }

        $form = $this->createForm(SchoolCodeType::class);
        if ($formHandler->handle($form, $request, $this->getUser()->getUserId())) {
            return $this->redirect($this->generateUrl('welcome'));
        }
        return $this->render('frontend/schoolCodeIndex.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}