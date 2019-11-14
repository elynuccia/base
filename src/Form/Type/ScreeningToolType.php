<?php
/**
 * Created by PhpStorm.
 * User: eleonoramariscalco
 * Date: 10/10/2018
 * Time: 10:01
 */

namespace App\Form\Type;

use App\Entity\ScreeningTool;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Student;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScreeningToolType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $schoolCode = $options['schoolCode'];

        $builder->add('screeningToolData', CollectionType::class, array(
            'entry_type' => ScreeningToolDataType::class,

        ));
            $builder->add('student', EntityType::class, [
                // looks for choices from this entity
                'class' => Student::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'code',
                'choice_label' => function ($student) {
                        return $student->getNickname() . ' (' . $student->getCode() . ')';
                    },
                'attr' => array(
                    'class' => 'mdb-select md-form'),
                //non si vede il bordo
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'label'=>false,
                'query_builder' => function (EntityRepository $er) use ($schoolCode) {
                    // here you can use the $country variable in your anonymous function.
                    return $er->createQueryBuilder('c')
                        ->where('c.schoolCode = ?1')
                        ->setParameter(1, $schoolCode)
                        ->orderBy('c.nickname', 'ASC');

                },
            ]);


        $builder->add('submit', SubmitType::class, array('label'=>'Save'));
        //  $builder->add('submitAndAdd', SubmitType::class, array('label'=>'Save and Add'));

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

            'data_class' => ScreeningTool::class,
            'schoolCode' => null,

        ]);
    }
}
