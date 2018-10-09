<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:10
 */

namespace App\Controller;

use App\Entity\ODR;
use App\Entity\LocationTag;
use App\Entity\MinorAndMajorBehavior;
use App\Form\Handler\ODRFormHandler;
use App\Form\Type\ODRType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ODRController extends AbstractController
{
    /**
     * @Route("/odr/", name="odr")
     */
    public function newOdr(Request $request, ODRFormHandler$formHandler)
    {
        $odr = new ODR();

        $form = $this->createForm(ODRType::class, $odr);

        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('odr_list'));
        }

        return $this->render('odr/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/odrlist", name="odr_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param ODRFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction() {


        $odr = $this->getDoctrine()->getRepository('App\Entity\ODR')->findAll();
        $odrMinMaj = $this->getDoctrine()->getRepository('App\Entity\ODR')->countMinorAndMajorBehaviorsById();


        return $this->render('odr/list.html.twig', array(

            'odr' => $odr,
            'minMaj' => $odrMinMaj
        ));
    }

}