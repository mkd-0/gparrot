<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname',  TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nom prénom'
            ])

            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'label' => 'Email'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])

                ]
            ])

            ->add('subject', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Objet'
            ])


            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Message',
                'constraints' => [
                    new Assert\NotBlank(),
                ]
            ])



            ->add('submit',  SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-4'],
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
