<?php

namespace App\Controller\Admin;

use App\Entity\TypeRecette;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeRecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeRecette::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('nomTpRec'),
            AssociationField::new('recettes')
            ->hideOnIndex(),
        ];
    }

}
