<?php

namespace App\Form;

use App\Entity\Hotel;
use App\Entity\Reservation;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($options['hotel']->getNomHotel());
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
                'required' => false,
            ]);

            
    }           

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'hotel' => null, // Définissez l'option 'hotel' avec une valeur par défaut null
        ]);
    }
}
