<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 10:23
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;




class PaginaProvvisoria extends AbstractController
{

    /**
     * @Route("/provvisorio", name="provvisorio")
     */
    public function index() {

        return $this->render('provvisoria/new.html.twig');

    }
}