<?php
namespace App\Form\Type;

use App\Entity\Measure;
use App\Entity\Observation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;

class BaseObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('required' => true))
            ->add('description', TextareaType::class, array('required' => true))
            ->add('fillingInstructions', TextareaType::class, array('required' => false, 'translation_domain' => 'forms'))
            ->add('place', TextareaType::class, array('required' => false, 'translation_domain' => 'forms'))
            ->add('setting', TextareaType::class, array('required' => false, 'translation_domain' => 'forms'))
            ->add('measure', EntityType::class, array(
                    'attr' => array(
                        'data-live-search' => 'true',
                        'title' => 'Choose one of the following...',
                        'data-size' => 5
                    ),
                    'required' => true,
                    'class' => Measure::class,
                    'choice_label' => 'name',
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        return $er->createQueryBuilder('m')
                            ->where('m.schoolCode = :schoolCode')
                            ->setParameter('schoolCode', $options['schoolCode'])
                            ->orderBy('m.name', 'asc')
                            ;
                    },
                )
            )
            ->add('submit', SubmitType::class, array(
                'translation_domain' => 'forms'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'inherit_data' => true,
            'creatorUserId' => array(),
            'schoolCode' => null
        ));
    }
}