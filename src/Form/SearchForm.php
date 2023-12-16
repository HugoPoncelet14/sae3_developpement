<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Region;
use App\Entity\TypeRecette;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pays', EntityType::class, [
               'label' => false,
                'required' => false,
                'class' => Pays::class,
                'expanded' => false,
                'multiple' => true,
                ])
            ->add('region', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Region::class,
                'expanded' => false,
                'multiple' => true,
                ])
            ->add('typeRecette', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => TypeRecette::class,
                'expanded' => false,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           'data_class' => SearchData::class,
           'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
