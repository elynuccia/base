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
use App\Entity\School;
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
     * @Route("/cico", name="cico")
     * @Method({"GET", "POST"})
     */
    public function index( Request $request , CicoFormHandler $formHandler)
    {

        $cico = new Cico();

        $schoolCode=$this->getUser()->getSchoolCode();


        $matrix = $this->getDoctrine()->getRepository('App\Entity\Matrix')->findMBySchoolCode($schoolCode);

        if(isset($matrix[0])) {
            $cico->setMatrix($matrix[0]);

            $cicoThreshold = new CicoThreshold();
            $cicoThreshold->setCico($cico);
            $cico->addCicoThreshold($cicoThreshold);
            $cico->setGainedPoints($cico->calculatePoints());

            $matrix = $cico->getMatrix();

        }
        $form = $this->createForm(CicoType::class, $cico, array( 'schoolCode'=> $schoolCode));
        //dump($form);

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