<?php

namespace App\Form;

use App\Entity\Pays;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPays', null, [
                'empty_data' => '',
                'label' => 'Nom du pays',
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'label' => 'Région',
                'choice_label' => 'nomReg',
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
