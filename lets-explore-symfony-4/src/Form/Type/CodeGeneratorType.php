<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 13/06/18
 * Time: 12:26
 */

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CodeGeneratorType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('numberOfCodes', IntegerType::class, array(
            'mapped'=> false,
        ));
        $builder->add('submit', SubmitType::class, array('label' => 'Save'));



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}