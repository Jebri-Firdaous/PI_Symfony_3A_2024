<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Medecin;
use App\Entity\RendezVous;
use App\Entity\User;
use App\Repository\MedecinRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

 


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
        ->add('user', EntityType::class, [
            'class' => User::class,
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
                'data' => "Anesthesiology"
                ])
                
                // ->add('idMedecin', EntityType::class, [
                //     'class' => Medecin::class,
                //     'choice_label' => 'nomMedecin', // Ensure this property exists in your Medecin entity
                //     'label' => 'Nom Medecin',
                //     'placeholder' => 'Choisissez un médecin',
                // ])
                

            ->add('dateRendezVous')
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
            'medecinRepository' => MedecinRepository::class,
            'usertRepository' => null,
            'entityManager' => null,
        ]);
    }
}
