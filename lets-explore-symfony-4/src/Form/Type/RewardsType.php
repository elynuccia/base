<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 14/09/18
 * Time: 10:39
 */

namespace App\Form\Type;

use App\Entity\Rewards;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RewardsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      /*  $builder->add('rewardTags', CollectionType::class, array(
            'entry_type' => RewardTagType::class,
            'entry_options' => array('label' => false),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,

        ));*/

        $builder->add('name');
        $builder->add('value');

        $builder->add('submit', SubmitType::class, array('label'=>'Save'));
        $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));



    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => Rewards::class,
        ]);
    }

}