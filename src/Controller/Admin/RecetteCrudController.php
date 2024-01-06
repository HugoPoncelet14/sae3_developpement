<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RecetteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recette::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('nomRec'),
            TextField::new('descRec')
                ->hideOnIndex(),
            AvatarField::new('imgRec')->setHeight(50),
            IntegerField::new('tpsDePrep')
                ->hideOnIndex(),
            Field::new('nbrCallo')
            ->hideOnIndex(),
            AssociationField::new('typeRecette')
                ->hideOnIndex(),
            AssociationField::new('pays')
                ->hideOnIndex(),

            AssociationField::new('ustensiles')
                ->hideOnIndex(),
        ];
    }
}
