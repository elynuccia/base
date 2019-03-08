<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 10/10/2018
 * Time: 10:01
 */

namespace App\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Student;
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
            $builder->add('student', EntityType::class, [
                // looks for choices from this entity
                'class' => Student::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'code',
                'attr' => array(
                    'class' => 'custom-select custom-select-md'),
                //non si vede il bordo
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'label'=>false,
            ]);



        $builder->add('submit', SubmitType::class, array('label'=>'Save'));
        //  $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));




    }
}