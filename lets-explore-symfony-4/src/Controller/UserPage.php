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

class UserPage extends AbstractController
{
    /**
     * @Route("/userpage", name="user_page")
     */
    public function index()
    {

        $user = $this->getUser();


        return $this->render('user/new.html.twig', array(
            'user'=>$user,
        ));
    }
    }