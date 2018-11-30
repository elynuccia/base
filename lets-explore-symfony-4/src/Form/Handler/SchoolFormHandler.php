<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 31/08/18
 * Time: 11:29
 */

namespace App\Form\Handler;

use App\Entity\School;
use App\Utility\SchoolAccessDataGenerator;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment as Twig;

class SchoolFormHandler
{
    private $entityManager;
    private $session;
    private $schoolAccessDataGenerator;
    private $mailer;
    private $engineInterface;

    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        SchoolAccessDataGenerator $schoolAccessDataGenerator,
        \Swift_Mailer $mailer,
        Twig $engineInterface

    )
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->schoolAccessDataGenerator = $schoolAccessDataGenerator;
        $this->mailer = $mailer;
        $this->engineInterface = $engineInterface;
    }

    public function handle(FormInterface $form, Request $request)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }


        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $schoolFormData = $form->getData();
            $lastId = $this->create($schoolFormData);

            return $lastId;
        }

    }

    public function create(School $entity)
    {
        $entity->setCode($this->schoolAccessDataGenerator->generateCode());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        $message = (new \Swift_Message('BASE APP: Your Personal Code'))
            ->setFrom('eleonoramariscalco@gmail.com')
            ->setTo($entity->getAdministrator()->getPersonalMail())
            ->setBody(
                $this->engineInterface->render(
                // templates/emails/registration.html.twig
                    'email/registration.html.twig',
                    array(
                        'code' => $entity->getCode()
                    )
                ),
                'text/html'
            )

            /*->addPart(
                $this->renderView(
                    'emails/registration.txt.twig',
                    array()
                ),
                'text/plain'
            )*/

        ;

        $this->mailer->send($message);

        return $entity->getId();
    }

}