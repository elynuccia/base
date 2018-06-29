<?php


namespace App\Controller;


use App\Form\Type\ShippingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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