<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/06/2019
 * Time: 13:06
 */

namespace App\Form\Type;

use App\Validator\Constraints\isSetSchoolCode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class SchoolCodeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('submit', SubmitType::class, array('label' => 'Save'));

        $builder->add('schoolCode', null, array(

            'mapped' => false,
            'constraints' => array(
                new isSetSchoolCode()

            )
        ));

    }

}