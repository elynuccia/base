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
use App\Form\Type\CicoType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Handler\CicoFormHandler;

use Symfony\Component\HttpFoundation\Request;

class CicoController extends AbstractController
{
    /**
     * @Route("/cico", name="cico")
     * @Method({"GET", "POST"})
     */
    public function index(/*Request $request , CicoFormHandler $formHandler*/)
    {
        $cico = new Cico();

        $form = $this->createForm(CicoType::class, $cico);

        return $this->render('cico/new.html.twig', array(
            'form' => $form->createView(),
        ));
        /* $matrix = new Matrix();



         $form = $this->createForm(MatrixType::class, $matrix);

         if ($lastId = $formHandler->handle($form, $request)) {
             return $this->redirect($this->generateUrl('matrix_behavior_new', array('id' => $lastId)));
         }


         return $this->render('matrix/index.html.twig', array(
             'form' => $form->createView(),
         )); */

    }
}