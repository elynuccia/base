<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 11:04
 */

namespace App\Controller;

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