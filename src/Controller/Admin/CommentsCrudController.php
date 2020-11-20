<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comments::class;
    }

public function configureActions(Actions $actions): Actions
{
    $removeComment = Action::new('removeComment','Supprimer', 'fa fa-trash')
        ->linkToCrudAction(Action::DELETE)
        ->addCssClass('btn btn-danger')
    ;
    return $actions
        ->disable(Action::EDIT)
        ->add(Action::DELETE, $removeComment)
    ;

}
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('posts.title','Titre'),
            TextField::new('users.name','Nom'),
            TextEditorField::new('content','Commentaire'),
        ];
    }

}
