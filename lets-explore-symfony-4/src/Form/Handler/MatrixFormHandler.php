<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 06/07/18
 * Time: 10:44
 */

namespace App\Form\Handler;


use Symfony\Component\HttpFoundation\Request;

use App\Entity\Matrix;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Doctrine\ORM\EntityManagerInterface;


class MatrixFormHandler
{
    private $entityManager;
    private $session;

    public function __construct(
        EntityManagerInterface $entityManager,
        SessionInterface $session
    )
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
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


        if ($form->isSubmitted() && $form->isValid()
        ) {
            $matrixFormData = $form->getData();
            $lastId = $this->create($matrixFormData);

            return $lastId;
        }


    }

    public function create(Matrix $entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity->getId();
    }

}