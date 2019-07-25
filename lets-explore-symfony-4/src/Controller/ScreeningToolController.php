<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 10/10/2018
 * Time: 09:49
 */

namespace App\Controller;

use App\Entity\ScreeningTool;
use App\Entity\ScreeningToolData;
use App\Entity\Matrix;
use App\Form\Handler\ScreeningToolFormHandler;
use App\Form\Type\ScreeningToolType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScreeningToolController extends AbstractController
{

    /**
     * @Route("/screeningtool/", name="screening_tool")
     * @Method({"GET", "POST"})
     */
    public function newScreeningTool(Request $request, ScreeningToolFormHandler $formHandler)
    {
        $schoolCode=$this->getUser()->getSchoolCode();

        $mat = $this->getDoctrine()->getRepository('App\Entity\Matrix')->findMBySchoolCode($schoolCode);

        $matrix = null;

        $screeningTool = new ScreeningTool();


        if(isset($mat[0])) {
            $screeningTool->setMatrix($mat[0]);

            foreach ($screeningTool->getMatrix()->getExpectationTags() as $expectation) {
                $screeningToolData = new ScreeningToolData();
                $screeningToolData->setExpectation($expectation);
                $screeningTool->addScreeningToolData($screeningToolData);
            }

            $matrix = $screeningTool->getMatrix();
        }


        $form = $this->createForm(ScreeningToolType::class, $screeningTool);

        if ($lastId = $formHandler->handle($form, $request)) {
            //dump($lastId);
            return $this->redirect($this->generateUrl('screeningtool_list'));
        }

        return $this->render('screeningtool/new.html.twig', array(
            'form' => $form->createView(),
            'matrix'=> $matrix,
            'screeningTool' => $screeningTool,
        ));
    }

    /**
     * @Route("/screeningtoollist", name="screeningtool_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param ScreeningToolFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction() {


        $screeningTool = $this->getDoctrine()->getRepository('App\Entity\ScreeningTool')->findAll();
        $valueByExp = $this->getDoctrine()->getRepository('App\Entity\ScreeningToolData')->countValueByExpectation();

    dump($valueByExp);
        return $this->render('screeningtool/list.html.twig', array(

            'screeningTool' => $screeningTool,
            'valueByExp' => $valueByExp,

        ));
    }




}