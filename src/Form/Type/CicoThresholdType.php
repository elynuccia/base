<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 14/09/18
 * Time: 10:39
 */

namespace App\Form\Type;

use App\Entity\CicoThreshold;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CicoThresholdType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder->add('threshold');
        $builder->add('value');




    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => CicoThreshold::class,
        ]);
    }

}