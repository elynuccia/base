<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 18/09/18
 * Time: 11:46
 */

namespace App\Controller;
use App\Entity\CicoData;
use App\Entity\CicoSession;
use App\Entity\Student;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Cico;
use App\Entity\Matrix;

use App\Form\Type\CicoType;
use App\Form\Type\CicoSessionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Handler\CicoFormHandler;

use Symfony\Component\HttpFoundation\Request;

class CicoDataController extends AbstractController
{
    /**
     * @Route("/cicodata/{id}", name="cico_data")
     * @Method({"GET", "POST"})
     */
    public function index(Cico $cico, Request $request, CicoFormHandler $formHandler)
    {

        $schoolCode=$this->getUser()->getSchoolCode();

        $session = new CicoSession();
        $session->setCico($cico);
        $student= $cico->getStudent();
        //dump($student);
        for ($i = 1; $i <= $cico->getPeriodNumber(); $i++) {
            foreach ($cico->getMatrix()->getExpectationTags() as $expectation) {
                $cicoData = new CicoData();
                $cicoData->setSession($session);
                $cicoData->setExpectation($expectation);

                $session->addData($cicoData);
            }
        }

        $cico->addSession($session);

        $form = $this->createForm(CicoType::class, $cico, array( 'schoolCode'=> $schoolCode));



        if ($lastId = $formHandler->handle($form, $request)) {
            $nextAction = $form->get('submitAndAdd')->isClicked()
                ? 'cico_data'
                : 'cico_list';

            return $this->redirect($this->generateUrl($nextAction, array('id' => $lastId)));
            //return $this->redirect($this->generateUrl('cico_data', array('id' => $lastId)));
        }

        return $this->render('cico/new2.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $cico->getMatrix(),
            'id' => $cico->getId(),
            'cico' => $cico,
            'student' => $student

        ));

    }



    /**
     * @Route("/cicolist/{id}/", name="cico_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param CicoFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
     public function listAction(Cico $cico  /*,Student $student*/) {

         //dump($cico);
                  /*
         $cico = $this->getDoctrine()->getRepository('App\Entity\Cico')->findAll();
         $cicoData = $this->getDoctrine()->getRepository('App\Entity\CicoData')->findAll();
         $cicoSession = $this->getDoctrine()->getRepository('App\Entity\CicoSession')->findAll();
         */


         return $this->render('cico_data/list.html.twig', array(
             'cico'=>$cico,
             //'student' =>$student
         ));

      //   return array('cico' => $cico);
     }

    /**
     * @Route("/allcicos", name="all_cicos")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param CicoFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAllAction() {

        $schoolCode= $this->getUser()->getSchoolCode();
       // $cicoSession = $this->getDoctrine()->getRepository('App\Entity\CicoSession')->findAll();
        $cicos = $this->getDoctrine()->getRepository('App\Entity\Cico')->findCicoBySchoolCode( $schoolCode);


        return $this->render('cico_data/allList.html.twig', array(
            //'session' => $cicoSession,
            'cicos' => $cicos,
        ));

        //   return array('cico' => $cico);
    }
    /**
     * @Route("/cicodata_new/{id}", name="cicodata_new")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param CicoFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, CicoSession $session, CicoFormHandler $formHandler) {

        $cico = $session->getCico();

        for ($i = 1; $i <= $cico->getPeriodNumber(); $i++) {
            foreach ($cico->getMatrix()->getExpectationTags() as $expectation) {
                $cicoData = new CicoData();
                $cicoData->setSession($session);
                $cicoData->setExpectation($expectation);

                $session->addData($cicoData);
            }
        }

        $form = $this->createForm(CicoSessionType::class, $session);


/*
            if ($lastId = $formHandler->handle($form, $request)) {

                $nextAction = $form->get('submitAndAdd')->isClicked()
                    ? 'cicodata_new'
                    : 'cico_list';

                return $this->redirect($this->generateUrl($nextAction, array('id' => $session->getId())));
                }*/

        return $this->render('cico/new3.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $cico->getMatrix(),
            'id' => $cico->getId(),
            'cico' => $cico,
        ));

    }


}