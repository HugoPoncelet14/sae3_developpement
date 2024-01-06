<?php

namespace App\Controller\Admin;

use App\Entity\Quantite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuantiteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quantite::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            IntegerField::new('quantite')
            ->hideOnIndex(),
            TextField::new('unitMesure')
                ->hideOnIndex(),
            AssociationField::new('recette'),
            AssociationField::new('ingrediant'),
        ];
    }

}
