<?php

namespace App\Controller\Admin;

use App\Entity\Allergene;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AllergeneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Allergene::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('nomAll'),
            AssociationField::new('ingrediants'),
            AssociationField::new('users'),
        ];
    }
}
