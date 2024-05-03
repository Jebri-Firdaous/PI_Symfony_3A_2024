<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class RegistrationAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('personne', PersonneType::class) // Ajout du champ 'personne' en utilisant PersonneType
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
        ])
        ->add('Submit', SubmitType::class); // Bouton de soumission
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'csrf_protection' => false, // Disable CSRF protection
        ]);
    }
}