<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 18/09/18
 * Time: 10:56
 */

namespace App\Form\Type;

use App\Entity\CicoSession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CicoSessionType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('data', CollectionType::class, array(
            'entry_type' => CicoDataType::class,
        ));

        $builder->add('fillInDate', TextType::class, [
            'required' => true,
        ]);
        $builder->add('submit', SubmitType::class, array('label'=>'Save'));
        $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => CicoSession::class,
        ]);
    }

}