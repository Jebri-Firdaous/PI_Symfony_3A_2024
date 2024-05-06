<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
        ->add('email', emailType::class, [
            'label' => 'Adresse Mail',
            'attr' => ['placeholder' => 'Saisir votre adresse mail'],
        ])
            ->add('mdp_personne', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Login',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure CSRF protection
            'csrf_protection' => true,
            // Specify the path for form submission
            'action' => '/login',
        ]);
    }
}
