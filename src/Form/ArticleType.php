<?php
namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomArticle')
            ->add('prixArticle')
            ->add('quantiteArticle')
            ->add('typeArticle', ChoiceType::class, [
                'choices' => [
                    'Electronique' => 'Electronique',
                    'Vetements' => 'Vetements',
                    'Livres' => 'Livres',
                    'Appareils_menagers' => 'Appareils_menagers',
                    'Equipements_sportifs' => 'Equipements_sportifs',
                    'Produits_de_beaute' => 'Produits_de_beaute',
                    'Meubles' => 'Meubles',
                    'Jouets' => 'Jouets',
                    'Alimentation_et_boissons' => 'Alimentation_et_boissons',
                    'Bijoux' => 'Bijoux',
                ],
                'placeholder' => 'Choisir un type',
            ])            
            ->add('descriptionArticle', TextareaType::class, [
                'label' => 'Description de l\'article',
                'attr' => [
                    'rows' => 5, // Nombre de lignes pour la zone de texte
                    'class' => 'form-control', // Classes CSS supplémentaires
                ],
            ])
            ->add('photoArticle', FileType::class, [
                'label' => 'Photo (JPEG, PNG, GIF)',
                'mapped' => false,
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter Article',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
