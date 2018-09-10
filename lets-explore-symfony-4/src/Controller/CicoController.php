<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 30/08/18
 * Time: 14:07
 */

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Cico;
use App\Entity\Matrix;
use App\Form\Type\CicoType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Handler\CicoFormHandler;

use Symfony\Component\HttpFoundation\Request;

class CicoController extends AbstractController
{
    /**
     * @Route("/cico/{id}", name="cico")
     * @Method({"GET", "POST"})
     */
    public function index(Matrix $matrix, Request $request , CicoFormHandler $formHandler)
    {
        $cico = new Cico();
        $cico->setMatrix($matrix);

        $form = $this->createForm(CicoType::class, $cico);
        dump($form);

        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('cico_new', array('id' => $lastId)));
        }

        return $this->render('cico/new.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $matrix,
            'id' => $cico->getId(),
            'cico' => $cico,
        ));

        // $matrix = new Matrix();





    }


    /**
     * @Route("/cico_new/{id}", name="cico_new")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param CicoFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Cico $cico, CicoFormHandler $formHandler) {

        $form = $this->createForm(CicoType::class, $cico, array(
            //'matrix' => $cico->getMatrix(),
            //'cico' => $cico,
            'action' => $this->generateUrl('cico_new', array(
                'id'=>$cico->getId()
            ))
        ));

      /*  if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('cico_new', array('id' => $lastId)));
        }
*/
        return $this->render('cico/new2.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $cico->getMatrix(),
            'id' => $cico->getId(),
            'cico' => $cico,
        ));

    }
}