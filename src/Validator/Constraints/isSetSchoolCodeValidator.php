<?php
namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class isSetSchoolCodeValidator extends ConstraintValidator {

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($schoolCode, Constraint $constraint)
    {
        $repository = $this->entityManager->getRepository('App:School');

        $existingSchool = $repository->findOneBySchoolCode($schoolCode);

        if (!$existingSchool) {
            $this->context->buildViolation($constraint->message)
                ->atPath('schoolCode')
                ->setParameter('{{ string }}', $schoolCode)
                ->addViolation();
        }
    }
}