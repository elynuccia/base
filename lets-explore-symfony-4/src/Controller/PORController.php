<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:10
 */

namespace App\Controller;

use App\Entity\POR;
use App\Entity\Student;
use App\Form\Handler\PORFormHandler;
use App\Form\Type\PORType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PORController extends AbstractController
{
    /**
     * @Route("/por/", name="por")
     */
    public function newOdr(Request $request, PORFormHandler$formHandler)
    {
        $por = new POR();
        $userId = $this->getUser()->getUserId();

        $form = $this->createForm(PORType::class, $por,  array( 'teacherCoordinator' => $userId));

        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('por_list'));
        }

        return $this->render('por/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/porlist", name="por_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param PORFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction() {


        $por = $this->getDoctrine()->getRepository('App\Entity\POR')->findAll();
        $porPosBehavior = $this->getDoctrine()->getRepository('App\Entity\POR')->countPositiveBehaviorsById();


        return $this->render('por/list.html.twig', array(

            'por' => $por,
            'porPosBehavior' => $porPosBehavior
        ));
    }

}