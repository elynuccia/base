<?php
namespace App\Controller;
use App\Form\Handler\CalendarFormHandler;
use App\Form\Type\CalendarType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use App\Entity\Measure;
use App\Entity\Observation;
use App\Form\Handler\MeasureFormHandler;
use App\Form\Type\MeasureType;
use App\Form\Builder\FormBuilder;
use App\Form\Handler\ItemFormHandler;
/**
 * @Route("/measure")
 *
 * Class MeasureController
 * @package App\Controller
 */
class MeasureController extends Controller
{
    CONST NEW_COMPLETE_SUCCESS_STRING = 'Data saved successfully';
    CONST NEW_SUCCESS_STRING = 'Record inserted successfully';
    CONST EDIT_SUCCESS_STRING = 'Record edited successfully';
    CONST DATES_ADDED_SUCCESS = 'Dates added successfully';
    CONST DELETE_SUCCESS_STRING = 'Record deleted successfully';
    CONST CALENDAR_TITLE = 'Pick your favourite dates';
    CONST NEW_TITLE = 'Insert new observation';
    CONST EDIT_TITLE = 'Edit observation';
    CONST INDEX_TITLE = 'List of observations';
    /**
     * @Route("/list", name="measure_list")
     * @Method({"GET"})
     * @Template
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $records = $this->getDoctrine()->getRepository('App\Entity\Measure')->findBySchoolCode(
            $this->getUser()->getSchoolCode()
        );
        return array(
            'records' => $records,
            'title' => $this->get('translator')->trans(self::INDEX_TITLE)
        );
    }
    /**
     * @Route("/edit/{id}", name="measure_edit")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param Measure $observation
     * @param MeasureFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Measure $measure, MeasureFormHandler $formHandler)
    {
        $formHandler->setOriginalChoiceItems($measure->getChoiceItems());
        $formHandler->setOriginalDirectObservationItems($measure->getDirectObservationItems());
        $formHandler->setOriginalIntegerItems($measure->getIntegerItems());
        $formHandler->setOriginalMeterItems($measure->getMeterItems());
        $formHandler->setOriginalRangeItems($measure->getRangeItems());
        $formHandler->setOriginalTextItems($measure->getTextItems());
        $form = $this->createForm(MeasureType::class, $measure, array(
            'action' => $this->generateUrl('measure_edit', array('id' => $measure->getId())),
        ));
        if($formHandler->handle($form, $request, $this->get('translator')->trans(self::EDIT_SUCCESS_STRING),
            $this->getUser()->getSchoolCode())) {
            return $this->redirect($this->generateUrl('measure_list'));
        }
        return $this->render('measure/new.html.twig',
            array(
                'form' => $form->createView(),
                'title' => $this->get('translator')->trans(self::EDIT_TITLE),
                'numberOfItems' => $measure->countItems(),
                'actionName' => 'Edit'
            )
        );
    }

    /**
     * @Route("/new", name="measure_new")
     * @Method({"GET", "POST"})
     * @Template
     *
     * @param Request $request
     * @param MeasureFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, MeasureFormHandler $formHandler)
    {
        $entity = new Measure();
        $entity->setCreatorUserId($this->getUser()->getUserId());
        $form = $this->createForm(MeasureType::class, $entity, array(
            'action' => $this->generateUrl('measure_new')
        ));

        if($formHandler->handle($form, $request, $this->get('translator')->trans(self::NEW_SUCCESS_STRING),
            $this->getUser()->getSchoolCode())) {
            return $this->redirect($this->generateUrl('measure_list'));
        }
        $numberOfItems = $form->get('choiceItems')->count() + $form->get('directObservationItems')->count() +
            $form->get('integerItems')->count() + $form->get('meterItems')->count() +
            $form->get('rangeItems')->count() + $form->get('textItems')->count();
        return array(
            'form' => $form->createView(),
            'title' => $this->get('translator')->trans(self::NEW_TITLE),
            'actionName' => 'New',
            'numberOfItems' => $numberOfItems
        );
    }
    /**
     * @Route("/delete/{ids}", name="measure_delete")
     * @Method({"GET"})
     *
     * @param Request $request
     * @param Measure $entity
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {
        $ids = json_decode($request->get('ids'), true);
        $em = $this->getDoctrine()->getManager();

        foreach($ids as $id) {
            $measure = $em->getRepository('App\Entity\Measure')->find($id);

            $observations = $em->getRepository('App\Entity\Observation')->findByMeasure($measure);

            if(!$observations) {
                $flashTypology = 'success';
                $flashMessage = self::DELETE_SUCCESS_STRING;

                $em->remove($measure);
                $em->flush();
            } else {
                $flashTypology = 'warning';
                $flashMessage = sprintf('You can\'t delete the measure "%s": it has been already associated to at least to an observation.', (string) $measure);
            }

        }

        $this->get('session')->getFlashbag()->add($flashTypology, $flashMessage);

        return $this->redirect($this->generateUrl('measure_list'));
    }
    /**
     * @Route("/{id}/{token}", name="measure")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @param Measure $observation
     * @param ItemFormHandler $formHandler
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Template
     */
    public function createFormAction(Request $request,
                                     FormBuilder $formBuilder,
                                     Observation $observation,
                                     ItemFormHandler $formHandler,
                                     $token)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository('App\Entity\Item')->findItemsByMeasure($observation->getMeasure());
        if(!$observation->getIsEnabled() ||
            !$observation->isDateIncluded(new \DateTime()) ||
            $observation->getToken() != $token) {
            $nextDate = $em->getRepository('App\Entity\ObservationDate')->findNextObservationDate($observation);
            return $this->render('measure/not_allowed.html.twig', array(
                'nextDate' => $nextDate,
                'observation' => $observation
            ));
        }
        $formBuilder->addItems($items);
        $formBuilder->setAction($observation);
        $formBuilder->setObservationId($observation->getId());
        $formBuilder->setUserId($this->getUser()->getUserId());
        $form = $formBuilder->getForm()->getForm();
        if ($formHandler->handle($form, $request, $this->get('translator')->trans(self::NEW_COMPLETE_SUCCESS_STRING))) {
            return $this->redirect($this->generateUrl('measure', array(
                'id' => $observation->getId(),
                'token' => $observation->getToken()
            )));
        }
        return array(
            'form' => $form->createView(),
            'title' => 'Data gathering',
            'observation' => $observation
        );
    }
}