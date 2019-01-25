<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 23/11/2018
 * Time: 10:40
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
{
    /**
     * @Route("/adminpersonalpage", name="admin_personalpage")
     */
    public function index() {

        $admin = $this->getUser();


        return $this->render('admin/new.html.twig', array(
            'admin'=> $admin,
        ));

    }
}