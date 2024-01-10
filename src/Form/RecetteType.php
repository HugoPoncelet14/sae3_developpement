<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Pays;
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
            ->add('nomRec', null, ['label' => 'Nom de la recette'])
            ->add('descRec', null, ['label' => 'Description de la recette'])
            ->add('imgRec', FileType::class, [
                'required' => false,
                'label' => 'Image de la recette',
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/jpg'],
                        'mimeTypesMessage' => 'Veuillez entrer un type mime valide (JPEG,JPG,PNG)',
                    ]),
                ],
            ])
            ->add('tpsDePrep', NumberType::class, ['label' => 'Temps de préparation'])
            ->add('tpsCuisson', NumberType::class, [
                'required' => false,
                'label' => 'Temps de cuisson',
                ])
            ->add('nbrCallo', NumberType::class, ['label' => 'Nombre de callories'])
            ->add('nbrPers', NumberType::class, ['label' => 'Nombre de personne(s)'])
            ->add('typeRecette', EntityType::class, [
                'class' => TypeRecette::class,
                'choice_label' => 'nomTpRec',
                'label' => 'Type de la recette',
            ])
            ->add('pays', EntityType::class, [
                'class' => Pays::class,
                'choice_label' => 'nomPays',
                'label' => "Pays d'origine",
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
