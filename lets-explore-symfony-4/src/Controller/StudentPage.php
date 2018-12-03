<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 10:40
 */

namespace App\Controller;
use App\Entity\Student;
use App\Utility\Auth0Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentPage extends AbstractController
{
    /**
     * @Route("/studentpage", name="student_page")
     */
    public function index() {

        $student = $this->getUser();


        return $this->render('student/new.html.twig', array(
            'student'=> $student,
        ));

    }
}