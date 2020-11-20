<?php

namespace App\Controller\Admin;

use App\Entity\Posts;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Posts::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->overrideTemplate('crud/index','bundles/EasyAdminBundle/custom/crud_index_custom.html.twig')
            ->overrideTemplate('crud/edit', 'bundles/EasyAdminBundle/custom/crud_edit_custom.html.twig')
            ->overrideTemplate('crud/detail','bundles/EasyAdminBundle/custom/crud_detail_custom.html.twig')
            ->overrideTemplate('crud/new', 'bundles/EasyAdminBundle/custom/crud_new_custom.html.twig')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $imageFields =ImageField::new('imageFile')
                ->setFormType( VichImageType::class)
                ->setLabel('Image');
        $image =ImageField::new('imageName')
                ->setBasePath('/uploads/images')
                ->setLabel('Image');


        $fields=[
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title','Titre'),
            TextEditorField::new('description','Description')
               ->setFormType( CKEditorType::class),
            TimeField::new('createdAt','Création')->onlyOnIndex(),
            TimeField::new('updatedAt', 'Modification')->onlyOnIndex(),
        ];

        if ($pageName === Crud::PAGE_INDEX || $pageName === Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFields;
        }
        
        return $fields;
    }
}
