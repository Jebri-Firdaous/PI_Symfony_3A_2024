<?php

// src/Form/PersonneType.php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class PersonneType extends AbstractType
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
            ->add('numero_telephone', IntegerType::class, [
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
            ->add('image_personne');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
