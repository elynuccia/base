<?php
namespace App\Form\Type;

use App\Entity\ExpectationTag;
use App\Entity\LocationTag;
use App\Entity\MatrixBehavior;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;



class BehaviorTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('behavior')
            ->add('location', EntityType::class, array(
                'class' => LocationTag::class,
                'choice_label'=> 'name',
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('e')
                        ->where('e.matrix = :matrix')
                        ->setParameter('matrix', $options['matrix']);
                }
            ))
                  ->add('expectation', EntityType::class, array(
                      'class' => ExpectationTag::class,
                      'choice_label'=> 'name',
                      'query_builder' => function (EntityRepository $er) use ($options) {
                          return $er->createQueryBuilder('e')
                              ->where('e.matrix = :matrix')
                              ->setParameter('matrix', $options['matrix']);
                      }
                  ));
              //  ->add('expectation',null,array( 'attr'=>array('style'=>'display:none;')) );
        //devi aggiungere il campo nascosto per expectation e location ma si aspetta una stringa
        //ho provato anche expectationtags senza hidden type ma nada
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'matrix' => null,
            'data_class' => MatrixBehavior::class,
        ));
    }
}