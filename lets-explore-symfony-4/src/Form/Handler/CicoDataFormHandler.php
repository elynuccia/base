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


class CicoDataFormHandler
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
            $cicoFormData = $form->getData();

           dump($cicoFormData);exit;

            $lastId = $this->create($cicoFormData, $form->get('fillInDate')->getData());

            return $lastId;
        }


    }

    public function create(CicoData $entity, $fillInDate)
    {
        //dump($fillInDate); exit;
       // $totCols = $entity->getTmpData();

        /*foreach(explode(',', $totCols) as $key => $totCol) {
            $fillInDateTime = \DateTime::createFromFormat('U', strtotime($fillInDate));*/


        //$cicoData = new CicoData();
           // $cicoData->setExpectation($entity->getMatrix()->getExpectationTags()->get($key));
           // $cicoData->setCico($entity);
           // $cicoData->setValue($totCol);
            //$cicoData->setFillInDate($fillInDateTime);

           // $entity->addData($cicoData);
        /*}*/

      //  $entity->setTmpData(null);
        //$fillInDateTime = \DateTime::createFromFormat('U', strtotime($fillInDate));
        //$entity->setFillInDate($fillInDateTime);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();

        return $entity->getId();
    }

}