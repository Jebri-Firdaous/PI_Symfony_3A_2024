<?php

namespace App\Form;

use App\Entity\Administrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AdministrateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('personne', PersonneType::class)
        ->add('role', ChoiceType::class, [
            'choices' => [
                'Gestion Transport' => 'Gestion Transport',
                'Gestion Santé' => 'Gestion Santé',
                'Gestion Utilisateur' => 'Gestion Utilisateur',
                'Gestion Parking' => 'Gestion Parking',
                'Gestion Shopping' => 'Gestion Shopping',
                'Gestion Tourisme' => 'Gestion Tourisme',
                // Ajoutez d'autres choix si nécessaire
            ],
            'required' => false, // Rend le champ optionnel
            'placeholder' => 'Sélectionnez un role', // Placeholder par défaut
        ])
        ->add('Submit', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Administrateur::class,
        ]);
    }
}