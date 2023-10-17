<?php

namespace App\Form;

use App\Entity\Professor;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigProfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('professor', EntityType::class, [
                'class' => Professor::class,
                'placeholder' => 'Sélectionner un professeur',
                'choice_label' => 'name',
                'data' => $options['data'],
                'multiple' => false,
                'expanded' => false,
                'label' => false,
                'mapped' => false,
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
