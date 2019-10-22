<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 10/10/2018
 * Time: 13:36
 */

namespace App\Form\Type;

use App\Entity\ScreeningToolData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScreeningToolDataType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', ChoiceType::class, array(
            'choices' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
            ),
            'multiple' => false,
            'expanded' => true,
            'attr' => array ('class'=>'form-check-inline')

        ))
                ->add('expectation');

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => ScreeningToolData::class,
        ]);
    }

}