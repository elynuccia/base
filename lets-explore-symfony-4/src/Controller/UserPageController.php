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
use GuzzleHTTP\Client as GuzzleClient;
use App\Utility\Auth0Api;

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
    }