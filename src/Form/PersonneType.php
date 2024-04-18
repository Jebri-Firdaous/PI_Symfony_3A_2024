<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    private $transformer;
    public function __construct(StringToFileTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
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
        ->add('mail_personne', EmailType::class, [
            'label' => 'Adresse Mail',
            'attr' => ['placeholder' => 'Saisir votre adresse mail'],
        ])
        ->add('mdp_personne', PasswordType::class, [
            'label' => 'Mot de Passe',
            'attr' => ['placeholder' => 'Saisir votre mot de passe'],
        ])
        ->add('image_personne', FileType::class, [
            'label' => 'Image',
            'required' => false, // Set to false if the field is not required
        ]);

    // Add view transformer
    $builder->get('image_personne')->addModelTransformer($this->transformer);
}
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
