<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 15/06/18
 * Time: 11:48
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class QrCodeController extends AbstractController
{/**
 * @Route("/qrcode", name="qrcode")
 */
    public function index(Request $request)
    {


        return $this->render('/codegenerator/codegenerator.html.twig', array(

        ));
    }

}