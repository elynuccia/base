<?php


namespace App\Controller;


use App\Form\Type\ShippingType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FormController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function index(Request $request)
    {

        $form = $this->createForm(ShippingType::class);
        $form->handleRequest($request);


        return $this->render('form/fields.html.twig', [
            'form' => $form,
            'form' => $form->createView(),
        ]);
    }
}