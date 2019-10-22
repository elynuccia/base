<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 04/12/2018
 * Time: 13:20
 */

namespace App\Form\Type;

use App\Entity\Administrator;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $choices= $options['users_id'];
        $builder->add('check', ChoiceType::class, array(
            'multiple'=>true,
            'expanded'=>true,
            'choices' => $choices,
            'mapped' => false,

        ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'users_id' => null,
            'data_class' => Administrator::class,
        ]);
    }
}