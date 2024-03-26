<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;







class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom_personne', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Entrer votre nom'],
            'constraints' => [
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z]*$/',
                    'message' => 'Le nom ne peut contenir que des lettres majuscules ou minuscules.'
                ])
            ]
        ])
        ->add('prenom_personne', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Entrer votre prénom'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Veuillez entrer votre prénom.']),
                new Assert\Regex([
                    'pattern' => '/^[a-zA-Z]*$/',
                    'message' => 'Le prénom ne doit contenir que des lettres majuscules ou minuscules.'
                ])
            ]
        ])
        
        ->add('numero_telephone', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Entrer les 8 chiffres du numéro de téléphone'],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Veuillez entrer les 8 chiffres du numéro de téléphone.']),
                new Assert\Regex([
                    'pattern' => '/^\d{8}$/',
                    'message' => 'Le numéro de téléphone doit contenir exactement 8 chiffres.'
                ])
            ]
        ])
            ->add('mail_personne', EmailType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrer votre adresse e-mail'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer votre adresse e-mail.']),
                    new Assert\Email(['message' => 'Veuillez entrer une adresse e-mail valide.'])
                ]
            ])
            ->add('mdp_personne')
            ->add('image_personne', FileType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Choisissez votre image',
                'mapped' => false, // Ne mappe pas ce champ à une entité
                'required' => false // Le champ n'est pas obligatoire
            ])
            ->add('genre', ChoiceType::class, [
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre'
                ],
                'required' => true, // Définir à true pour forcer la sélection d'une option
                'placeholder' => '', // Retirer le placeholder pour ne pas avoir de valeur par défaut
            ])
            ->add('age', IntegerType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrer votre âge'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez entrer votre âge.']),
                    new Assert\Range([
                        'min' => 1,
                        'max' => 99,
                        'minMessage' => 'L\'âge doit être supérieur ou égal à 1.',
                        'maxMessage' => 'L\'âge doit être inférieur ou égal à 99.',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
