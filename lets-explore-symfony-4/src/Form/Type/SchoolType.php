<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 02/10/2018
 * Time: 13:38
 */

namespace App\Form\Type;

use App\Entity\School;
use App\Entity\Administrator;
use App\Form\Type\AdministratorType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


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

        $builder->add('submit', SubmitType::class, array('label' => 'Save'));
        $builder->add('numberOfCodes');
        $builder->add('name');
        $builder->add('address');
        $builder->add('phoneNumber');
        $builder->add('email');
        $builder->add('code');
        $builder->add('administrator', AdministratorType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => School::class,
        ]);
    }
}
