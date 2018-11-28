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
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Doctrine\ORM\EntityManagerInterface;


class SchoolFormHandler
{
    private $entityManager;
    private $session;
    private $schoolAccessDataGenerator;

    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $session,
        SchoolAccessDataGenerator $schoolAccessDataGenerator

    )
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->schoolAccessDataGenerator = $schoolAccessDataGenerator;
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

        return $entity->getId();
    }

}