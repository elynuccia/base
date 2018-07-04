<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MatrixType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motto')
            ->add('expectations', ChoiceType::class, array(
                'choices'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',


                ),
                'mapped' => false,
            ));

$builder->add('expectationTags', CollectionType::class, array(
    'entry_type' => TagType::class,
    'entry_options' => array('label' => false),
    'allow_add' => true,
    'by_reference' => false
))

            ->add('locations', ChoiceType::class, array(
                'choices'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ),
                'mapped' => false,
            ));


    $builder->add('locationTags', CollectionType::class, array(
        'entry_type' => TagType::class,
        'entry_options' => array('label' => false),
        'allow_add' => true,
        'by_reference' => false
    ));



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
