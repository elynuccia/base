<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 30/08/18
 * Time: 14:12
 */

namespace App\Form\Type;

use App\Entity\Cico;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CicoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periodNumber', ChoiceType::class, array(
                //'placeholder' => 'Select the number of Expectations',
                'choices' => array(
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'attr' => array(
                    'class' => 'mdb-select md-form'
                )

            ));

        $builder->add('student', EntityType::class, [
            // looks for choices from this entity
            'class' => Student::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'code',
            'attr' => array(
                'class' => 'mdb-select md-form'),
            //non si vede il bordo
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
            'label'=>false,
        ]);


        $builder->add('sessions', CollectionType::class, array(
            'entry_type' => CicoSessionType::class,

        ));
        $builder->add('submit', SubmitType::class, array('label'=>'Save and Exit'));
        $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and add another Cico'));

        $builder->add('threshold', HiddenType::class);
        $builder->add('tmpData', HiddenType::class);

        $builder
            ->add('numberOfThresholds', ChoiceType::class, array(
                //'placeholder' => 'Select the number of Expectations',
                'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ),
                'mapped'=> false,
                'attr' => array(
                    'class' => 'mdb-select md-form'
                )

            ));
        $builder->add('cicoThresholds', CollectionType::class, array(
        'entry_type' => CicoThresholdType::class,
            'allow_add' => true,

    ));
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Cico::class,
        ]);
    }

}