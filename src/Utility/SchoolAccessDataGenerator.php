<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 28/11/2018
 * Time: 09:53
 */

namespace App\Utility;

use Doctrine\ORM\EntityManagerInterface;

class SchoolAccessDataGenerator
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function generateCode($number) {
        $code = random_bytes($number);
        $code = strtoupper(bin2hex($code));

        if($this->entityManager->getRepository('App\Entity\School')->findOneByCode($code)) {
            $this->generateCode();
        }

        return $code;
    }
}