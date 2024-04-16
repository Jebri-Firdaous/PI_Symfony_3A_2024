<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('personne', PersonneType::class) // Ajout du champ 'personne' en utilisant PersonneType
        ->add('genre', ChoiceType::class, [
            'choices' => [
                'Femme' => 'Femme',
                'Homme' => 'Homme',
                'Autre' => 'Autre',
            ],
            'required' => false, // Rend le champ optionnel
            'placeholder' => 'Sélectionnez un genre', // Placeholder par défaut
        ])
        ->add('age', IntegerType::class, [
            'attr' => [
                'placeholder' => 'Entrez votre âge',
            ],
            'required' => false, // Rend le champ optionnel
        ])
        ->add('Submit', SubmitType::class); // Bouton de soumission
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class, // Classe de données associée au formulaire
        ]);
    }
}