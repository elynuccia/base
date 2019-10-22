<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 19/10/2018
 * Time: 14:13
 */

namespace App\Utility;

use App\Entity\PersonInCharge;
use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use chillerlan\QRCode\QRCode;
use Faker\Factory;

class AccessDataGenerator
{
    private $entityManager;
    private $qrCode;

    public function __construct(QRCode $QRCode, EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->qrCode = $QRCode;
    }

    public function generateAccessData($number, $teacherUsername, $schoolCode)
    {

        $results = array();


        for($i=1; $i<=$number; $i++) {
            $studentCode = $this->generateCode();
            $personInChargeCode = $this->generateCode();

            $student = new Student();
            $personInCharge = new PersonInCharge();

            $student->setCode($studentCode);
            $student->setNickname($this->generateNickname());
            $student->setQrCode($this->generateQrCode($studentCode));
            $student->setTeacherCoordinator($teacherUsername);
            $student->setSchoolCode($schoolCode);


            $personInCharge->setCode($personInChargeCode);
            $personInCharge->setQrCode($this->generateQrCode($personInChargeCode));

            $student->setPersonInCharge($personInCharge);

            $this->entityManager->persist($student);
            $this->entityManager->flush();

            $results[] = $student->getId();

            /*
            $results[] = array(
                'nickname' => $this->generateNickname(),
                'code' => $code,
                'qrCode' => $this->generateQrCode($code)
            );
            */
        }

        return $results;
    }

    private function generateNickname() {
        $faker = Factory::create();

        return $faker->firstName . $faker->unique()->randomDigit;
    }

    private function generateCode() {
        $code = random_bytes(4);
        $code = strtoupper(bin2hex($code));

        if($this->entityManager->getRepository('App\Entity\Student')->findOneByCode($code)) {
            $this->generateCode();
        }

        return $code;
    }

    private function generateQrCode($code) {
        return $this->qrCode->render($code);
    }



}