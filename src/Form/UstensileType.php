<?php

namespace App\Form;

use App\Entity\Recette;
use App\Entity\Ustensile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UstensileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'empty_data' => '',
                'label' => 'Nom de l\'ustensile'])
            ->add('imgUst', FileType::class, [
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ustensile::class,
        ]);
    }
}
