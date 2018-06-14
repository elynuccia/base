<?php

namespace App\Controller;

use App\Form\Type\CodeGeneratorType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function index()
    {
        $random = random_bytes(10);
        dump($random);
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

    /**
     * @Route("/hello/{name}", name="hello_page", defaults={"name" = "User"})
     * @param string $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function hello(string $name = 'CodeReviewVideos', Request $request)
    {
        $random = bin2hex(random_bytes(4));

        $form = $this->createForm(CodeGeneratorType::class);
        $form->handleRequest($request);



        return $this->render('hello_page.html.twig', [
            'person_name' => $name,
            'random'=> $random,
            'form' => $form,
            'form' => $form->createView(),


        ]);
    }
}
