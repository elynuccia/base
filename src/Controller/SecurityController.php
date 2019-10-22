<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Zxing\QrReader;


class SecurityController extends AbstractController
{
    /**
     * @Route("/codelogin", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $image = __DIR__  .  "/../../public/img/qrcode.png";
        $qrcode = new QrReader($image);
        $qrcode->text();
        //dump($qrcode);
        //legge il qr code correttamente, vedere il result trovare un modo per usarlo per il login e buona pasqua

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



}
