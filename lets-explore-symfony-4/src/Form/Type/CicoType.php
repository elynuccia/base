<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 30/08/18
 * Time: 14:12
 */

namespace App\Form\Type;

use App\Entity\Cico;
use App\Entity\CicoData;
use Symfony\Component\Form\AbstractType;


use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

            ));


        $builder->add('sessions', CollectionType::class, array(
            'entry_type' => CicoSessionType::class,

        ));
        $builder->add('submit', SubmitType::class, array('label'=>'Save'));
        $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));

        $builder->add('threshold', HiddenType::class);
        $builder->add('tmpData', HiddenType::class);
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Cico::class,
        ]);
    }

}