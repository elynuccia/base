<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 18/09/18
 * Time: 10:56
 */

namespace App\Form\Type;

use App\Entity\CicoData;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CicoDataType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //da togliere
      //  $builder->add('submit', SubmitType::class, array('label'=>'Save'));
      //  $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));

        $builder->add('value', ChoiceType::class, array(
            'choices' => array(
                1 => 1,
                2 => 2,
                3 => 3
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

            'data_class' => CicoData::class,
        ]);
    }

}