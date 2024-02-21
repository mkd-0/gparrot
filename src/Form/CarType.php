<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Color;
use App\Entity\Energy;
use App\Entity\Equipment;
use App\Entity\Model;
use App\Entity\Picture;
use App\Entity\Year;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Brand', EntityType::class, [
                'class' => 'App\Entity\Brand',
                'choice_label' => 'name', // 'nom' du champ que l'on souhaite afficher dans le menu déroulant
                'attr' => ['class' => 'form-control'],
                'label' => 'Marque'
            ])


            ->add('Model', EntityType::class, [
                'class' => 'App\Entity\Model',
                'choice_label' => 'name', // 'nom' du champ que l'on souhaite afficher dans le menu déroulant
                'attr' => ['class' => 'form-control'],
                'label' => 'Modèle'
            ])

            ->add('Color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control'],
                'label' => 'Couleur'
            ])

            ->add('Energy', EntityType::class, [
                'class' => Energy::class,
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control'],
                'label' => 'Energie'
            ])

            ->add('Year', EntityType::class, [
                'class' => Year::class,
                'attr' => ['class' => 'form-control'],
                'label' => 'Année'
            ])


            ->add('Mileage', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Kilométrage'
            ])

            ->add('Power', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Puissance'
            ])

            ->add('Equipment', EntityType::class, [
                'class' => Equipment::class,
                'required' => false, // Définir le champ comme non obligatoire
                'choice_label' => 'name',
                'multiple' => true, // Pour indiquer que c'est une relation ManyToMany
                'attr' => ['class' => 'form-control'],
                'label' => 'Options'
                //'expanded' => true, // Facultatif : pour afficher les options sous forme de cases à cocher plutôt que dans un menu déroulant
            ])





            ->add('DateCirculation', DateType::class, [
                //'widget' => 'single_text',
                'format' => 'dd-MM-yyyy', // Format que vous souhaitez utiliser
                //'html5' => false, // Si vous ne souhaitez pas utiliser le type de champ HTML5 natif
                // 'attr' => ['class' => 'datepicker'], // Ajoutez des classes supplémentaires pour la personnalisation CSS (facultatif)
                'label' => 'Date de mise en circulation'
            ])

            ->add('Price', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Prix'
            ])

            ->add('imageFile', VichImageType::class, [
                'label' => 'Image',
                'required' => false,
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
