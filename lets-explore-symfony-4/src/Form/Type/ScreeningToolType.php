<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 10/10/2018
 * Time: 10:01
 */

namespace App\Form\Type;

use App\Entity\ScreeningToolData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ScreeningToolType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('screeningToolData', CollectionType::class, array(
            'entry_type' => ScreeningToolDataType::class,
        ));

          $builder->add('submit', SubmitType::class, array('label'=>'Save'));
        //  $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));




    }
}