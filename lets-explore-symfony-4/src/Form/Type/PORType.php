<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 05/10/2018
 * Time: 11:13
 */

namespace App\Form\Type;

use App\Entity\POR;
use App\Entity\Student;
use App\Entity\LocationTag;
use App\Entity\MatrixBehavior;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;

class PORType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $teacherCoordinator = $options['teacherCoordinator'];
        $schoolId = $options['schoolId'];

        $builder->add('student', EntityType::class, [
            // looks for choices from this entity
            'class' => Student::class,

            // uses the User.username property as the visible option string
            'choice_label' => 'code',
            'attr' => array(
                'class' => 'mdb-select md-form'),
            'query_builder' => function (EntityRepository $er) use ($teacherCoordinator) {
                // here you can use the $country variable in your anonymous function.
                return $er->createQueryBuilder('c')
                    ->where('c.teacherCoordinator = ?1')
                    ->setParameter(1, $teacherCoordinator);

            },
            //non si vede il bordo
            // used to render a select box, check boxes or radios
            // 'multiple' => true,
            // 'expanded' => true,
            'label'=>false,

        ]);

        $builder->add('positiveBehaviors', EntityType::class, array(
            // looks for choices from this entity
            'class' => MatrixBehavior::class,
            'query_builder' => function (EntityRepository $er) use ($schoolId) {
                return $er->createQueryBuilder('u')
                    ->join('u.matrix', 'm')
                    ->join('m.school', 's')
                    ->where('s.id = :schoolId')
                    ->setParameter('schoolId', $schoolId)
                    ->orderBy('u.id', 'ASC');
            },

            // uses the User.username property as the visible option string
            'choice_label' => 'behavior',

            // used to render a select box, check boxes or radios
            'multiple' => true,
            'expanded' => true,
        ));

        $builder->add('locations', EntityType::class, array(
            // looks for choices from this entity
            'class' => LocationTag::class,
            'query_builder' => function (EntityRepository $er) use ($schoolId) {
                return $er->createQueryBuilder('l')
                    ->join('l.matrix', 'm')
                    ->join('m.school', 's')
                    ->where('s.id = :schoolId')
                    ->setParameter('schoolId', $schoolId)
                    ->orderBy('l.id', 'ASC');
            },

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

            'data_class' => POR::class,
            'teacherCoordinator' => null,
            'schoolId' => null,

        ]);
    }

}