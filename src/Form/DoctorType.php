<?php

namespace App\Form;

use App\Entity\Medecin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DoctorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomMedecin', TextType::class ,  ['required' => false, 'label' =>'Nom', 'attr' => array('style' => 'width: 300px')])
            ->add('prenomMedecinMedecin', null ,  ['required' => false, 
                                                    'label' =>'Prenom', 
                                                    'attr' => array('style' => 'width: 300px'),])
                                                   
            ->add('numeroTelephoneMedecin', null ,  ['required' => false, 'label' =>'Numéro telephoe', 'attr' => array('style' => 'width: 300px')])
            ->add('addressMedecin', null ,  ['required' => false, 'label' =>'Adresse', 'attr' => array('style' => 'width: 300px')])
            ->add('specialiteMedecin', ChoiceType::class ,  [
                'required' => false,
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
            
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}