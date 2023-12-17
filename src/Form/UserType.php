<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('nom', null, [
                'empty_data' => '',
            ])
            ->add('prenom', null, [
                'empty_data' => '',
            ])
            ->add('dateNais', DateType::class, [
                'required' => false,
                'years' => range(date('Y') - 100, date('Y')),
            ])
            ->add('pseudo', null, [
                'empty_data' => '',
            ])
            ->add('photoProfil', FileType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Nouvelle photo de profil',
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez entrer un type mime valide (JPEG,PNG)',
                    ]),
                ],
            ])
            ->add('allergenes', EntityType::class, [
                'class' => Allergene::class,
                'choice_label' => 'nomAll',
                'multiple' => true,
                'expanded' => true,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
