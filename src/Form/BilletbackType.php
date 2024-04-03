<?php

namespace App\Form;
use App\Entity\Station;
use App\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class BilletbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('destinationVoyage')
            ->add('dateDepart')
            ->add('prix')
            ->add('duree')
            ->add('station', EntityType::class, [
                'class' => Station::class,
                'choice_label' => function ($station) {
                    return sprintf('%s - %s - %s', $station->getNomStation(), $station->getAdressStation(), $station->getType());
                },
                'placeholder' => 'Choisir une station',
            ]);
        
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}
