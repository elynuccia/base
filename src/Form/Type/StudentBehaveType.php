<?php
namespace App\Form\Type;

use App\Entity\StudentBehave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;




class StudentBehaveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('studentId', null, array('required' => true))
            ->add('sex', ChoiceType::class, array(
                'choices' => array(
                    'Male' => 0,
                    'Female' => 1
                )
            ))
            ->add('submit', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => StudentBehave::class,
        ));
    }
}