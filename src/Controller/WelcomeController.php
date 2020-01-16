<?php

namespace App\Controller;

use App\Form\Type\CodeGeneratorType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class WelcomeController extends AbstractController
{
    /**
     * @Route("/welcome/{logged_out}", name="welcome", requirements={"logged_out" = "\d+"})
     */
    public function index(Request $request, $logged_out=0)
    {
        if($request->get('logged_out')==1)
        {
            return $this->redirect('https://' . $_ENV['AUTH0_DOMAIN'] . '/v2/logout?returnTo=' . urlencode($this->get('router')->generate('app_login', array(), UrlGeneratorInterface::ABSOLUTE_URL)));
        }

        $user = $this->getUser();
       // $schoolCode= $user->getSchoolCode();

        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
            //'schoolCode' => $schoolCode

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

        $form = $this->createForm(CodeGeneratorType::class);
        $form->handleRequest($request);






        return $this->render('codegenerator/hello_page.html.twig', [
            'person_name' => $name,
            'form' => $form->createView(),


        ]);
    }
}
