<?php
namespace App\Controller;
use App\Security\Encoder\OpenSslEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use App\Entity\Observation;
use App\CouchDb\Client as CouchDbClient;
/**
 * @Route("/")
 *
 * Class HomepageController
 * @package App\Controller
 */
class HomepageController extends Controller
{
    /**
     * @Route("/homepage", name="homepage")
     * @Method({"GET"})
     * @Template
     *
     */
    public function homepageAction(Request $request)    {
        if($this->getUser()) {
            return $this->forward('App\Controller\HomepageController::dashboardAction', array(
                '_route' => $request->attributes->get('_route'),
                '_route_params' => $request->attributes->get('_route_params')
            ));
        }
        return array();
    }
    /**
     * @Route("/dashboard", name="dashboard")
     * @Method({"GET"})
     * @Template
     *
     */
    public function dashboardAction( CouchDbClient $couchDbClient)
    {
        $futureObservationDates = $this->getDoctrine()->getRepository('App\Entity\ObservationDate')
            ->findFutureObservations($this->getUser()->getUserId());
        $observationsWithoutDates = $this->getDoctrine()->getRepository('App\Entity\Observation')
            ->findWithoutDatesByCreatorUserId($this->getUser()->getUserId());
        $observations = $this->getDoctrine()->getRepository('App\Entity\Observation')
            ->findActiveObservationsByCreatorUserId($this->getUser()->getUserId());
        $numberOfStudents = $this->getDoctrine()->getRepository('App\Entity\StudentBehave')->countStudentsByUserId(
           $this->getUser()->getUserId()
        );
        $numberOfMeasures = $this->getDoctrine()->getRepository('App\Entity\Measure')->countMeasuresByUserId(
            $this->getUser()->getUserId()
        );
        $dataToBeCategorized = array();
        $numberOfAllData = 0;
        $numberOfAllUncategorizedData = 0;
        foreach($observations as $observation) {
            $observationData = $couchDbClient->getObservationsById($observation->getId());
            $numberOfAllObservations = count(json_decode($observationData->getContents())->rows);
            $numberOfUncategorizedData = $numberOfAllObservations - $observation->countCategorizedData();
            $numberOfAllData += $numberOfAllObservations;
            $numberOfAllUncategorizedData += $numberOfUncategorizedData;
            if($numberOfUncategorizedData > 0) {
                $dataToBeCategorized[] = array(
                    'student' => $observation->getStudent(),
                    'observation' => $observation,
                    'numberOfUncategorizedData' => $numberOfUncategorizedData
                );
            }
        }
        return array(
            'observationDates' => $futureObservationDates,
            'observationsWithoutDates' => $observationsWithoutDates,
            'dataToBeCategorized' => $dataToBeCategorized,
            'numberOfStudents' => $numberOfStudents,
            'numberOfMeasures' => $numberOfMeasures,
            'percentageCategorizedData' => ($numberOfAllData == 0) ? 'N. A.' : 100 - (int) ($numberOfAllUncategorizedData / $numberOfAllData * 100)
        );
    }
}