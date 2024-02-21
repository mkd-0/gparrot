<?php

namespace App\Form;

use App\Entity\Hour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('day')
            ->add('morning')
            ->add('afternoon')



            ->add('day', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Jour'
            ])

            ->add('morning', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Matin'
            ])

            ->add('afternoon', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Après-midi'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hour::class,
        ]);
    }
}
