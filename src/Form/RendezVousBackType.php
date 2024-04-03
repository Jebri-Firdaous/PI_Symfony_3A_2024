<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Medecin;
use App\Entity\RendezVous;
use App\Repository\MedecinRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

 


class RendezVousBackType extends AbstractType
{
    private $medecinRepository;

    public function __construct(MedecinRepository $medecinRepository)
    {
        $this->medecinRepository = $medecinRepository;
    }



    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id_personne', EntityType::class, [
            'class' => Client::class,
            // 'choice_label' => 'personne.getNomPersonne()', // Assuming 'nom' is the property you want to display in the choice list
            
            'label' => 'Nom Client',
            'placeholder' => 'Choisissez un client', // Optional: Adds a placeholder option to the select
        ])
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
            ->add('idMedecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'nomMedecin', // Assuming 'nom' is the property you want to display in the choice list
                'label' => 'Nom Medecin',
                'placeholder' => 'Choisissez un médecin', // Optional: Adds a placeholder option to the select
            ])
            
            ->add('dateRendezVous')
            
            // // ->add('specialiteMedecin', ChoiceType::class ,  [
            // //     'required' => false,
            // //     'mapped' => false,
            // //     'label' => 'Spécialité',
            // //     'attr' => [
            // //         'style' => 'width: 300px'
            // //     ],
            // //     'choices'  => [
            // //         "Anesthesiology" => "Anesthesiology",
            // //         "Cardiology" => "Cardiology",
            // //         "Dermatology" => "Dermatology",
            // //         "Endocrinology" => "Endocrinology",
            // //         "Gastroenterology" => "Gastroenterology",
            // //         "Neurology" => "Neurology",
            // //         "Obstetrics" => "Obstetrics",
            // //         "Ophthalmology" => "Ophthalmology",
            // //         "Orthopedics" => "Orthopedics",
            // //         "Pediatrics" => "Pediatrics",
            // //         "Psychiatry" => "Psychiatry",
            // //         "Radiology" => "Radiology",
            // //         "Urology" => "Urology"
            // //     ],
            // ])
            // ->add('id_personne',HiddenType::class)
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
            'medecinRepository' => null,
            'clientRepository' => null,
        ]);
    }
}
