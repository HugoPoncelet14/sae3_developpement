<?php

namespace App\Controller\Admin;

use App\Entity\Ustensile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UstensileCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ustensile::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('name'),
            // ImageField::new('imgUst'),
            AssociationField::new('recettes')
            ->hideOnIndex(),
        ];
    }
}
