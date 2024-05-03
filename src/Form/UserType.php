<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    private $transformer;

    public function __construct(StringToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $role = $options['ADMIN'] ?? null; // Fetch the default role from options

        $builder
        ->add('nom_personne', null, [
            'label' => 'Nom',
            'attr' => ['placeholder' => 'Saisir votre nom'],
        ])
        ->add('prenom_personne', null, [
            'label' => 'Prénom',
            'attr' => ['placeholder' => 'Saisir votre prénom'],
        ])
        ->add('numero_telephone', IntegerType::class, [
            'attr' => [
                'placeholder' => 'Entrez votre numéro de téléphone',
            ],
            'required' => false, // Rend le champ optionnel
            ])

            ->add('image_personne', FileType::class, [
                'label' => 'Image',
                'required' => false, // Set to false if the field is not required
            ])    
       ->add('email', emailType::class, [
            'label' => 'Adresse Mail',
            'attr' => ['placeholder' => 'Saisir votre adresse mail'],
        ])           
      

            
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de Passe',
                'attr' => ['autocomplete' => 'nouveau-motdepasse',
                'placeholder' => 'Saisir votre mot de paasse'],

                
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe est requis',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
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
            ])
                    ->add('Submit',SubmitType::class);       
                    $builder->get('image_personne')->addModelTransformer($this->transformer);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'role' => 'ADMIN', // Default role option

        ]);
    }
}
