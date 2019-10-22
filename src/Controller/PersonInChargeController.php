<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 24/05/2019
 * Time: 10:08
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PersonInChargeController extends AbstractController
{

    /**
     * @Route("/personinchargepage", name="personincharge_page")
     */
    public function index() {

        $parent = $this->getUser();
        $student= $parent->getStudent();
        $schoolCode= $student->getSchoolCode();
        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countOdrByStudent($student);
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPorByStudent($student);
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORByStudent($student);
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRByStudent($student);
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findRewardsBySchoolCode($schoolCode);
        $cicos = $this->getDoctrine()->getRepository('App\Entity\Cico')->findByStudent($student);

        return $this->render('person_in_charge/new.html.twig', array(
            'student'=> $student,
            'studentCode'=>$student->getCode(),
            'odrs' => $odrs,
            'pors' => $pors,
            'bestPors' => $bestPors,
            'bestOdrs' => $bestOdrs,
            'rewards' => $rewards,
            'cicos' => $cicos
        ));

    }

}