<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 30/08/18
 * Time: 14:07
 */

namespace App\Controller;
use App\Entity\CicoData;
use App\Entity\CicoThreshold;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Cico;
use App\Entity\Matrix;
use App\Form\Type\CicoType;
use App\Form\Type\CicoDataType;
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

        $cicoThreshold = new CicoThreshold();
        $cicoThreshold->setCico($cico);

        $cico->addCicoThreshold($cicoThreshold);

        $cico->setGainedPoints(0);
       /* $cicoThreshold = new CicoThreshold();
        $cicoThreshold->setCico($cico);

        $cico->addCicoThreshold($cicoThreshold);*/
        $form = $this->createForm(CicoType::class, $cico);
        dump($form);

        if ($lastId = $formHandler->handle($form, $request)) {
            return $this->redirect($this->generateUrl('cico_data', array('id' => $lastId)));
        }

        return $this->render('cico/new.html.twig', array(
            'form' => $form->createView(),
            'matrix' => $matrix,
            'id' => $cico->getId(),
            'cico' => $cico,
        ));

        // $matrix = new Matrix();





    }





}