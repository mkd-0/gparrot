<?php

namespace App\Form;

use App\Entity\Testimony;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestimonyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('visitorname', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Votre nom'
            ])

            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Témoignage'
            ])

            ->add('isok', CheckboxType::class, [
                'attr' => ['class' => 'form-check'],
                'label' => 'Validé ',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Testimony::class,
        ]);
    }
}
