<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:14
 */

namespace App\Form\Handler;
use App\Utility\Auth0Api;

use Symfony\Component\HttpFoundation\Request;
use App\Utility\AccessDataGenerator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Doctrine\ORM\EntityManagerInterface;

class CodeGeneratorFormHandler
{
    private $entityManager;
    private $session;
    private $accessDataGenerator;
    private $auth0Api;


    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        AccessDataGenerator $accessDataGenerator,
        Auth0Api $auth0Api

    )
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->accessDataGenerator = $accessDataGenerator;
        $this->auth0Api = $auth0Api;

    }

    public function handle(FormInterface $form, Request $request, $user)
    {
        if (!$request->isMethod('POST')) {
            return false;
        }

        $form->handleRequest($request);

        if (!$form->isValid()) {
            return false;
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $studentIds = $this->accessDataGenerator->generateAccessData($request->get('code_generator')['numberOfCodes'],
                $user->getUserId(), $user->getSchoolCode());

            $students = array_merge($user->getStudents(), $studentIds);

            $this->auth0Api->updateStudentUserMetadata($user->getUserId(), $students);

            return true;
        }

    }
}