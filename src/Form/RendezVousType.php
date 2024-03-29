<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specialiteMedecin', ChoiceType::class ,  [
                'required' => false,
                'mapped' => false,
                'label' => 'Spécialité',
                'attr' => [
                    'style' => 'width: 300px'
                ],
                'choices'  => [
                    "Anesthesiology" => "Anesthesiology",
                    "Cardiology" => "Cardiology",
                    "Dermatology" => "Dermatology",
                    "Endocrinology" => "Endocrinology",
                    "Gastroenterology" => "Gastroenterology",
                    "Neurology" => "Neurology",
                    "Obstetrics" => "Obstetrics",
                    "Ophthalmology" => "Ophthalmology",
                    "Orthopedics" => "Orthopedics",
                    "Pediatrics" => "Pediatrics",
                    "Psychiatry" => "Psychiatry",
                    "Radiology" => "Radiology",
                    "Urology" => "Urology"
                ],
            ])
            ->add('idMedecin',null, ['label' => 'Nom Medecin',])
            ->add('dateRendezVous')
            
            ->add('specialiteMedecin', ChoiceType::class ,  [
                'required' => false,
                'mapped' => false,
                'label' => 'Spécialité',
                'attr' => [
                    'style' => 'width: 300px'
                ],
                'choices'  => [
                    "Anesthesiology" => "Anesthesiology",
                    "Cardiology" => "Cardiology",
                    "Dermatology" => "Dermatology",
                    "Endocrinology" => "Endocrinology",
                    "Gastroenterology" => "Gastroenterology",
                    "Neurology" => "Neurology",
                    "Obstetrics" => "Obstetrics",
                    "Ophthalmology" => "Ophthalmology",
                    "Orthopedics" => "Orthopedics",
                    "Pediatrics" => "Pediatrics",
                    "Psychiatry" => "Psychiatry",
                    "Radiology" => "Radiology",
                    "Urology" => "Urology"
                ],
            ])
            // ->add('id_personne',HiddenType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
