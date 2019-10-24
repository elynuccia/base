<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 11:04
 */

namespace App\Controller;

use App\Entity\Student;
use App\Entity\School;
use Symfony\Component\Form\Util\StringUtil;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Utility\Auth0Api;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserPageController extends AbstractController
{
    /**
     * @Route("/userpage", name="user_page")
     */
    public function index()
    {
        $school = $this->getDoctrine()->getManager()->getRepository('App\Entity\School')->findOneBySchoolCode(
            $this->getUser()->getSchoolCode()
        );

        if(in_array('ROLE_USER_TEACHER_COORDINATOR', $this->getUser()->getRoles())) {

            $teacherCoordinator=$this->getUser()->getUserid();
            $students_byteacher = $this->getDoctrine()->getRepository('App\Entity\Student')->findStudentsByTeacherCoordinator( $teacherCoordinator);
        }
        else
        {
            $students_byteacher='';
        }

        $schoolCode= $school->getSchoolCode();

        $students = $this->getDoctrine()->getRepository('App\Entity\Student')->findStudentsBySchoolCode($schoolCode);
        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countMinorAndMajorBehaviorsBySchoolCode($schoolCode);
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRBySchoolCode($schoolCode);
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORBySchoolCode($schoolCode);
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPositiveBehaviorsBySchoolCode($schoolCode);
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findRewardsBySchoolCode($schoolCode);
        $user = $this->getUser();

        return $this->render('user/new.html.twig', array(
            'user'=> $user,
            'students' => $students,
            'students_byteacher' => $students_byteacher,
            'odrs' => $odrs,
            'pors' => $pors,
            'bestOdrs' => $bestOdrs,
            'bestPors' => $bestPors,
            'rewards' => $rewards

        ));
    }

    /**
     * @Route("/userpage_noschoolcode/", name="user_page_noschoolcode")
     */
    public function index2()
    {

        $user = $this->getUser();


        return $this->render('user/new_noschoolcode.html.twig', array(
            'user'=>$user,


        ));
    }



    /**
     * @Route("/studentdashboard/{id}", name="student_dashboard")
     */
    public function indexAction(Student $student)
    {
        $schoolCode=$student->getSchoolCode();

        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countOdrByStudent($student);
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPorByStudent($student);
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORByStudent($student);
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRByStudent($student);
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findRewardsBySchoolCode($schoolCode);
        $cicos = $this->getDoctrine()->getRepository('App\Entity\Cico')->findByStudent($student);



        $user = $this->getUser();

        // dump($auth0Api->getUsers(''));exit;
       // dump($odrs);exit;

        return $this->render('user/userdashboard.html.twig', array(
            'user'=>$user,
            'student' => $student,
            'studentCode'=>$student->getCode(),
            'odrs' => $odrs,
            'pors' => $pors,
            'bestPors' => $bestPors,
            'bestOdrs' => $bestOdrs,
            'rewards' => $rewards,
            'cicos' => $cicos

    ));
    }

    /**
     * @Route("/assignRewards/{id}", name="assign_rewards")
     */
    public function assignRewardsAction(Auth0Api $auth0Api, Request $request, Student $student)
    {
        if(!$request->isXmlHttpRequest()) {
            $response = new Response('not allowed');
            $response->setStatusCode(403);

            return $response;
        }

        foreach ($request->get('rewardPoints') as $rewardPoints) {
            $student->subPoints($rewardPoints);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($student);
        $entityManager->flush();

        return new Response($student->getPoints());
    }


    /**
     * @Route("/search", name="user_search")
     */
    public function search(Request $request, Auth0Api $auth0Api)
    {
        $results = array();

        if(!$request->isXmlHttpRequest()) {
            $response = new Response('not allowed');
            $response->setStatusCode(403);

            return $response;
        }

        foreach($auth0Api->getUsers($request->get('term')) as $key => $user) {
            $results[] = array(
                'id' => $user->user_id,
                'label' => '<img width="10%" src="' . $user->picture . '">' . $user->name . '</img>',
                'value' => $user->user_id,
                'picture' => $user->picture
            );


            /*
            $results['results'][] = array(
                'id' => $user->user_id,
                'text' => $user->name,
                'imageSrc' => $user->picture
            );*/
        }

        return new Response(
            json_encode($results)
        );
    }

    }