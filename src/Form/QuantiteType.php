<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuantiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        foreach ($options['ingredients'] as $ingredient) {
            $builder
                ->add("quantiteIng{$ingredient->getId()}", null, [
                    'label' => 'Quantité',
                ])
                ->add("unitMesureIng{$ingredient->getId()}", null, [
                    'label' => 'Unité de mesure',
                    'required' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'ingredients' => false,
        ]);
    }
}
