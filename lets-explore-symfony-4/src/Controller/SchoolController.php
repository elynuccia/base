<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 02/10/2018
 * Time: 13:36
 */

namespace App\Controller;

use App\Entity\School;
use App\Entity\MinorAndMajorBehavior;
use App\Form\Type\SchoolType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SchoolController extends AbstractController
{

    /**
     * @Route("/school", name="school")
     */
    public function new(Request $request)
    {
        $school = new School();

        $minorAndMajorBehavior = new MinorAndMajorBehavior();
        $minorAndMajorBehavior->setName('m1');
        $school->getMinorAndMajorBehaviors()->add($minorAndMajorBehavior);

        $form = $this->createForm(SchoolType::class, $school);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            dump($contactFormData);        }

        return $this->render('school/new.html.twig', array(
            'form' => $form->createView(),
        ));    }
}