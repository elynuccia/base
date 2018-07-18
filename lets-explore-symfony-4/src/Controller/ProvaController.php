<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 13/07/18
 * Time: 10:07
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProvaController extends Controller
{
    /**
     * @Route("/prova", name="prova")
     */
    public function new()
    {


        return $this->render('prova/new.html.twig', array(

        ));
    }
}