<?php

namespace App\Form;

use App\Entity\Professor;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $professor = $options['data'];
        $subjects = $professor->getSubjects();

        $builder
            ->add('name')
            ->add('subjects', EntityType::class, [
                'class' => Subject::class,
                'choice_label' => 'label',
                'expanded' => true,
                'multiple' => true,
                'label' => 'Matières',
                'choice_attr' => function ($subject, $key, $index) use ($subjects){
                    $selected = false;
                    foreach ($subjects as $s){
                        if ($subject == $s){
                            $selected = true;
                        }
                    }
                    return ['checked' => $selected];
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ok',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professor::class,
        ]);
    }
}
