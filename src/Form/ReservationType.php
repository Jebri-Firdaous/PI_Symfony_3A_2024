<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Hotel;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dureeReservation')
            ->add('prixReservation', TextType::class, [
                'required' => false,
                'attr' => [
                    'readonly' => true, // Make the field readonly initially
                ],
            ])
            ->add('dateReservation', DateTimeType::class, [
                'label' => 'Date et heure de la réservation',
                'widget' => 'single_text',
                'html5' => true,
                'attr' => [
                    'class' => 'form-control custom-input',
                ],
                'required' => true,
                'data' => new \DateTime(), // Valeur par défaut à aujourd'hui
            ])
            
            ->add('typeChambre', ChoiceType::class, [
                'choices' => [
                    'Normal' => 'normal',
                    'Standard' => 'standard',
                    'Luxe' => 'luxe',
                ],
                'placeholder' => 'Choisissez le type de chambre',
                'required' => false, // Permettre une valeur null
            ])
            ->add('idHotel', EntityType::class, [
                'class' => Hotel::class,
                'choices' => $options['hotelChoices'],
                'choice_label' => 'nomHotel',
                'placeholder' => 'Choisissez le nom de l\'hôtel',
                'multiple' => false,
                'required' => false,
            ]);
            
           // ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'hotelChoices' => [], // Ajoutez une option par défaut pour les choix d'hôtels
            'selectedHotelNames' => [], // Ajoutez l'option selectedHotelNames avec une valeur par défaut vide

        ]);
    }
}
