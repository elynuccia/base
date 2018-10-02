<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 02/10/2018
 * Time: 13:38
 */

namespace App\Form\Type;

use App\Entity\School;
use App\Entity\MinorAndMajorBehavior;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;

class SchoolType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('minorAndMajorBehaviors', CollectionType::class, array(
            'entry_type' => MinorAndMajorBehaviorType::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,

        ));
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => School::class,
        ]);
    }
}
