<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 06/07/18
 * Time: 10:44
 */

namespace App\Form\Handler;


use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Matrix;

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

        //$validObject = $form->getData();
       // $this->create($validObject);

        if ($form->isSubmitted() && $form->isValid()
        ) {
            $matrixFormData = $form->getData();
            dump($matrixFormData);
        }
    }
    /*
    public function create(Matrix $entity)
    {

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }*/

}