<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:13
 */

namespace App\Form\Type;

use App\Entity\ODR;
use App\Entity\LocationTag;
use App\Entity\MinorAndMajorBehavior;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;

class ODRType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('minorAndMajorBehaviors', EntityType::class, array(
            // looks for choices from this entity
            'class' => MinorAndMajorBehavior::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'name',

            // used to render a select box, check boxes or radios
            'multiple' => true,
             'expanded' => true,
        ));

        $builder->add('locations', EntityType::class, array(
            // looks for choices from this entity
            'class' => LocationTag::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'name',

            // used to render a select box, check boxes or radios
             'multiple' => true,
             'expanded' => true,
        ));


        $builder->add('fillInDate', TextType::class);
        $builder->add('note');
        $builder->add('submit', SubmitType::class, array('label'=>'Save'));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => ODR::class,
        ]);
    }

}