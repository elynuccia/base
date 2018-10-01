<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 31/08/18
 * Time: 11:29
 */

namespace App\Form\Handler;

use App\Entity\CicoData;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Cico;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


use Doctrine\ORM\EntityManagerInterface;


class CicoFormHandler
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
            $cicoForm = $form->getData();

            $lastId = $this->create($cicoForm);

            return $lastId;
        }


    }

    public function create(Cico $entity)
    {

        if($entity->getCicoThresholds()->isEmpty() == false) {
            foreach($entity->getCicoThresholds() as $relatedEntity) {
                $relatedEntity->setCico($entity);
            }
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity->getId();
    }

}