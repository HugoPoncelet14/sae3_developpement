<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomIng', null, [
                'empty_data' => '',
                'label' => 'Nom de l\'ingrédient',
            ])
            ->add('imgIng', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Image de l\'ingrédient',
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/jpg'],
                        'mimeTypesMessage' => 'Veuillez entrer un type mime valide (JPEG,JPG,PNG)',
                    ]),
                ],
            ])
            ->add('allergene', EntityType::class, [
                'required' => false,
                'class' => Allergene::class,
                'choice_label' => 'nomAll',
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
