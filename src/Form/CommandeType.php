<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Personne;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreArticle', IntegerType::class, [
                'label' => 'Nombre d\'articles'
            ])
            ->add('prixTotale', MoneyType::class, [
                'currency' => 'DT',
                'label' => 'Prix total'
            ])
            ->add('delaisCommande', DateTimeType::class, [
                'label' => 'Date limite de commande',
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd'
            ])
             // Ajout du bouton pour soumettre le formulaire
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
