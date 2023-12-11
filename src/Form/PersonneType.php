<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\Personne;
use App\Entity\TypePersonne;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPers')
            ->add('pnomPers')
            ->add('SHA512PASS')
            ->add('dateNais')
            ->add('pseudo')
            ->add('photoProfil')
            ->add('typePersonne', EntityType::class, [
                        'class' => TypePersonne::class,
                        'choice_label' => 'id'])
            ->add('allergenes', EntityType::class, [
                        'class' => Allergene::class,
                        'choice_label' => 'id',
                        'multiple' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
