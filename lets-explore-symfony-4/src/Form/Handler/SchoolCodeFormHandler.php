<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:14
 */

namespace App\Form\Handler;

use App\Entity\School;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Utility\Auth0Api;

use Doctrine\ORM\EntityManagerInterface;

class SchoolCodeFormHandler
{
    private $entityManager;
    private $session;
    private $auth0;

    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        Auth0Api $auth0
    )
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->auth0 = $auth0;
    }

    public function handle(FormInterface $form, Request $request, $userId)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $schoolCodeFormData = $request->request->get('school_code')['schoolCode'];

            $this->auth0->updateSchoolCodeUserMetadata($userId, $schoolCodeFormData);

            return true;
        }

    }




}