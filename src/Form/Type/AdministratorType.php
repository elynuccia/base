<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 26/11/2018
 * Time: 13:20
 */

namespace App\Form\Type;

use App\Entity\Administrator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class AdministratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName');
        $builder->add('lastName');
        $builder->add('personalMail');

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Administrator::class,
        ]);
    }
}