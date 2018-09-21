<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 18/09/18
 * Time: 11:46
 */

namespace App\Controller;
use App\Entity\CicoData;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Cico;
use App\Entity\Matrix;

use App\Form\Type\CicoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Handler\CicoDataFormHandler;

use Symfony\Component\HttpFoundation\Request;

class CicoDataController extends AbstractController
{
    /**
     * @Route("/cicodata/{id}", name="cico_data")
     * @Method({"GET", "POST"})
     */
    public function index(Cico $cico, Request $request, CicoDataFormHandler $formHandler)
    {
        //per ciascun periodo
            // per ciascuna aspettativa
            //$cicoData = new CicoData();
            //$cicoData->setExpectation($blabla);
            //$cico->addData($cicoData);

        for($i=1; $i<=$cico->getPeriodNumber(); $i++) {
            foreach($cico->getMatrix()->getExpectationTags() as $expectation) {
                $cicoData = new CicoData();
                $cicoData->setCico($cico);
                $cicoData->setExpectation($expectation);

                $cico->addData($cicoData);
            }
        }



        $form = $this->createForm(CicoType::class, $cico);
        //dump($form);

        /*
        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('cico_data', array('id' => $lastId)));
        }*/

        return $this->render('cico/new2.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $cico->getMatrix(),
            'id' => $cico->getId(),
            'cico' => $cico,
        ));

    }


    /**
     * @Route("/cicodata_new/{id}", name="cicodata_new")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param CicoDataFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */

    /*
    public function newAction(Request $request, CicoData $cicoData, CicoDataFormHandler $formHandler) {
        $form = $this->createForm(CicoType::class, $cico, array(
            'action' => $this->generateUrl('cico_new', array(
                'id'=>$cico->getId()
            ))
        ));

        if ($lastId = $formHandler->handle($form, $request)) {
            if ($lastId = $formHandler->handle($form, $request)) {

                $nextAction = $form->get('submitAndAdd')->isClicked()
                    ? 'cico_new'
                    : 'cico_list';

                return $this->redirect($this->generateUrl($nextAction, array('id' => $lastId)));
            }        }

        return $this->render('cico/new2.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $cico->getMatrix(),
            'id' => $cico->getId(),
            'cico' => $cico,
        ));

    }


    /**
     * @Route("/cicolist", name="cico_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param CicoDataFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
   /* public function listAction() {


        $cicoData = $this->getDoctrine()->getRepository('App\Entity\CicoData')->findAll();


        return $this->render('cico/list.html.twig', array(
            'cicoData'=>$cicoData,

        ));
    }*/
}