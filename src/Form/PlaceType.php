<?php

namespace App\Form;

use App\Entity\Parking;
use App\Entity\Place;
use App\Repository\PlaceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $parking = $options['parking'];
        $list = $options['list'];

        $builder
            ->add('numPlace', ChoiceType::class, [
                'choices' => array_combine($list, $list)
            ])
            ->add('typePlace', ChoiceType::class, [
                'choices' => [
                    'Voiture' => 'Voiture',
                    'Handicap' => 'Handicap',
                    'Camion' => 'Camion'
                ]
            ])
            // ->add('etat')
            // ->add('idParking', EntityType::class, [
            //     'class' => Parking::class,
            //     'choice_label' => 'idParking',
            //     'required' => true,
            //     'placeholder' => 'choose an idParking',
            //     'expanded' => true,
            //     'multiple' => false
            // ])
            // ->add('idUser')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
        ]);
        $resolver->setRequired('parking');
        $resolver->setAllowedTypes('parking', Parking::class);
        $resolver->setRequired('list');
        $resolver->setAllowedTypes('list', 'array');
    }
}
