<?php

namespace App\Form;

use App\Entity\Posts;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, ['label'=>'Titre'])
            ->add('description', CKEditorType::class)
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image(JPG or PNG file)',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'delete ?',
                'download_uri' => false,
                'imagine_pattern' => 'Squared_thumbnail_small'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
