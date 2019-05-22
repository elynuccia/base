<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 11:04
 */

namespace App\Controller;

use App\Entity\Student;
use App\Entity\Rewards;
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
    public function index(Auth0Api $auth0Api)
    {
        $students = $this->getDoctrine()->getRepository('App\Entity\Student')->findAll();
        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countMinorAndMajorBehaviorsById();
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRById();
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORById();
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPositiveBehaviorsById();
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findDistinct();
        $user = $this->getUser();

       // dump($auth0Api->getUsers(''));exit;


        return $this->render('user/new.html.twig', array(
            'user'=>$user,
            'students' =>$students,
            'odrs' => $odrs,
            'pors' => $pors,
            'bestOdrs' => $bestOdrs,
            'bestPors' => $bestPors,
            'rewards' => $rewards

        ));
    }

    /**
     * @Route("/studentdashboard/{id}", name="student_dashboard")
     */
    public function indexAction(Auth0Api $auth0Api, Request $request, Student $student)
    {


        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countOdrByStudent($student);
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPorByStudent($student);
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORByStudent($student);
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRByStudent($student);
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findDistinct();
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