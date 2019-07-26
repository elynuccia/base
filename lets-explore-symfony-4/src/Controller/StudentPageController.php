<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 10:40
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentPageController extends AbstractController
{
    /**
     * @Route("/studentpage", name="student_page")
     */
    public function index() {

        $student = $this->getUser();
        dump($student);
        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countOdrByStudent($student);
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPorByStudent($student);
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORByStudent($student);
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRByStudent($student);
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findDistinct();
        $cicos = $this->getDoctrine()->getRepository('App\Entity\Cico')->findByStudent($student);

        return $this->render('student/new.html.twig', array(
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