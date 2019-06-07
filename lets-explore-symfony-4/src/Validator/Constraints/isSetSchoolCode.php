<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class isSetSchoolCode extends Constraint {
    public $message = 'The school code  "{{ string }}" is not valid!';

    public function getTargets()
    {
        //return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}