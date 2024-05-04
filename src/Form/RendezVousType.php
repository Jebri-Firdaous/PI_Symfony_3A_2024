<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\RendezVous;
use App\Repository\MedecinRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
<<<<<<< HEAD
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

=======
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

 


class RendezVousType extends AbstractType
{
    private $medecinRepository;

    public function __construct(MedecinRepository $medecinRepository)
    {
        $this->medecinRepository = $medecinRepository;
    }



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
<<<<<<< HEAD
            // ->add('idMedecin', EntityType::class, [
            //     'class' => Medecin::class,
            //     'choice_label' => 'nomMedecin', // Assuming 'nom' is the property you want to display in the choice list
            //     'label' => 'Nom Medecin',
            //     'placeholder' => 'Choisissez un médecin', // Optional: Adds a placeholder option to the select
                
            // ])
=======
            ->add('idMedecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'nomMedecin', // Assuming 'nom' is the property you want to display in the choice list
                'label' => 'Nom Medecin',
                'placeholder' => 'Choisissez un médecin', // Optional: Adds a placeholder option to the select
                
            ])
>>>>>>> 37caec1e37e945f6c482a8a42503aea11ab64dea
            
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


        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();

                $specialite = $data['specialiteMedecin'];
                $medecinsbySpecialite = $this->medecinRepository->findBySpecialite($specialite);

                $form->add('idMedecin', EntityType::class, [
                    'class' => Medecin::class,
                    'choice_label' => 'nomMedecin',
                    'label' => 'Nom Medecin',
                    'placeholder' => 'Choisissez un médecin',
                    'choices' => $medecinsbySpecialite,
                ]);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
            'medecinRepository' => null,
        ]);
    }
}
