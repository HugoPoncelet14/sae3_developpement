<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Pays;
use App\Entity\Recette;
use App\Entity\TypeRecette;
use App\Entity\Ustensile;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomRec')
            ->add('descRec')
            ->add('imgRec', FileType::class, [
                'required' => false,
                'label' => 'Photo de profil',
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/jpg'],
                        'mimeTypesMessage' => 'Veuillez entrer un type mime valide (JPEG,JPG,PNG)',
                    ]),
                ],
            ])
            ->add('tpsDePrep', NumberType::class)
            ->add('tpsCuisson', NumberType::class, [
                'required' => false,
                ])
            ->add('nbrCallo', NumberType::class)
            ->add('nbrPers', NumberType::class)
            ->add('typeRecette', EntityType::class, [
                'class' => TypeRecette::class,
                'choice_label' => 'nomTpRec',
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nomPays',
            ])
            ->add('ustensiles', EntityType::class, [
                'class' => Ustensile::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'nomIng',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.nomIng', 'ASC');
                },
            ])
            ->add('nbrEtapes', NumberType::class, [
                'label' => 'Nombre d\'étapes',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
