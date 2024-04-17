<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Personne;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombreArticle', IntegerType::class, [
            'label' => 'Nombre d\'articles',
            'required' => true,
            'attr' => [
                'min' => 1, // Quantité minimale autorisée
            ],
            'constraints' => [
                new Assert\NotBlank(['message' => 'Ce champ est requis.']),
                new Assert\Positive(['message' => 'La valeur doit être positive.']),
            ],
        ])
            ->add('prixTotale')
            ->add('delaisCommande', DateTimeType::class, [
                'label' => 'Date limite de commande',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter Commande'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
