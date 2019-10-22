<?php


namespace App\Controller;


use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormController extends AbstractController
{
    /**
     * @Route("/bootstrap2", name="bootstrap2")
     */
    public function index()
    {


        return $this->render('form/fields.html.twig');
    }
}