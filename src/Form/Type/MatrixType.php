<?php

namespace App\Form\Type;

use App\Entity\Matrix;
use App\Entity\ExpectationTag;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MatrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motto')
            ->add('expectations', ChoiceType::class, array(
                //'placeholder' => 'Select the number of Expectations',
                'choices' => array(
                        '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ),
                'mapped' => false,
                'attr' => array(
                    'class' => 'mdb-select md-form'
                )
            ));

$builder->add('expectationTags', CollectionType::class, array(
    'entry_type' => ExpectationTagType::class,
    'entry_options' => array('label' => false),
    'allow_add' => true,
    'by_reference' => false
))

            ->add('locations', ChoiceType::class, array(
                //'placeholder' => 'Select the number of Locations',
                'choices' => array(
                        '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',

                ),
                'mapped' => false,
                'attr' => array(
                    'class' => 'mdb-select md-form'
                )
            ));


    $builder->add('locationTags', CollectionType::class, array(
        'entry_type' => LocationTagType::class,
        'entry_options' => array('label' => false),
        'allow_add' => true,
        'by_reference' => false
    ));

        $builder->add('behaviorTags', CollectionType::class, array(
            'entry_type' => BehaviorTagType::class,
            'entry_options' => array(
                'label' => false,
                'matrix' => $options['matrix']
            ),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,


        ));

        $builder->add('submit', SubmitType::class);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => Matrix::class,
            'matrix' => null,
        ]);
    }
}
