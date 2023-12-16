<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
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