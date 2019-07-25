<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 14/09/18
 * Time: 10:23
 */

namespace App\Controller;
use App\Form\Type\RewardsType;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Entity\Rewards;
use App\Entity\School;
use App\Form\Handler\RewardFormHandler;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;

class RewardsController extends AbstractController

{
    /**
     * @Route("/rewards/{schoolCode}", name="rewards")
     * @Method({"GET", "POST"})
     */
    public function index(/*Matrix $matrix,*/ Request $request ,School $school, RewardFormHandler $formHandler)
    {
        $rewards = new Rewards();
        $rewards->setSchool($school);

        $schoolCode=$school->getSchoolCode();

        $form = $this->createForm(RewardsType::class, $rewards);
        dump($form);

        if ($lastId = $formHandler->handle($form, $request)) {

            $nextAction = $form->get('submitAndAdd')->isClicked()
                ? 'rewards'
                : 'rewards_list';

            return $this->redirect($this->generateUrl($nextAction , array ('schoolCode' => $schoolCode)));
        }

        return $this->render('rewards/new.html.twig', array(
            'form' => $form->createView(),

        ));
    }

    /**
     * @Route("/rewardslist/{schoolCode}", name="rewards_list")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param RewardFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(School $school) {
        $schoolCode= $school->getSchoolCode();
       $rewards = $this->getDoctrine()->getRepository('App\Entity\Rewards')->findRewardsBySchoolCode($schoolCode);


        return $this->render('rewards/list.html.twig', array(

            'rewards' => $rewards,
        ));
    }



    /**
     * @Route("/deletereward/{id}", name="reward_delete")
     * @Method({"GET"})
     *
     * @param Request $request
     * @param Rewards $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteMatrixAction(Request $request, Rewards $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $this->get('session')->getFlashbag()->add('success', 'Deleted');
        return $this->redirect($this->generateUrl('rewards_list'));
    }

}