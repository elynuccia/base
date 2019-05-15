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

        $user = $this->getUser();

       // dump($auth0Api->getUsers(''));exit;


        return $this->render('user/new.html.twig', array(
            'user'=>$user,
        ));
    }

    /**
     * @Route("/studentdashboard/{id}", name="student_dashboard")
     */
    public function indexAction(Auth0Api $auth0Api, Student $student)
    {

        $odrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countOdrByStudent($student);
        $pors = $this->getDoctrine()->getRepository('App\Entity\POR')->countPorByStudent($student);
        $bestPors = $this->getDoctrine()->getRepository('App\Entity\POR')->countBestPORByStudent($student);
        $bestOdrs = $this->getDoctrine()->getRepository('App\Entity\ODR')->countBestODRByStudent($student);
        $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findAll();


        $user = $this->getUser();

        // dump($auth0Api->getUsers(''));exit;
       // dump($odrs);exit;

        return $this->render('user/userdashboard.html.twig', array(
            'user'=>$user,
            'studentCode'=>$student->getCode(),
            'odrs' => $odrs,
            'pors' => $pors,
            'bestPors' => $bestPors,
            'bestOdrs' => $bestOdrs,
            'rewards' => $rewards

    ));
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