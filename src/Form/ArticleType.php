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
                    'Type 1' => 'Type 1',
                    'Type 2' => 'Type 2',
                    'Type 3' => 'Type 3',
                ],
                'placeholder' => 'Choisir un type',
            ])
            ->add('descriptionArticle')
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
