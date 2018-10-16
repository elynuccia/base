<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:14
 */

namespace App\Form\Handler;

use App\Entity\ScreeningTool;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Doctrine\ORM\EntityManagerInterface;

class ScreeningToolFormHandler
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


        if ($form->isSubmitted() && $form->isValid()) {
            $ScreeningToolFormData = $form->getData();
            $lastId = $this->create($ScreeningToolFormData);
            //    $lastId = $this->create($ODRFormData, $form->get('fillInDate')->getData());


            return $lastId;
        }

    }

    public function create(ScreeningTool $entity)
    {
        // $fillInDateTime = \DateTime::createFromFormat('U', strtotime($fillInDate));
        // $entity->setFillInDate($fillInDateTime);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity->getId();
    }


}