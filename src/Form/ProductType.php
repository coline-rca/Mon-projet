<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Size;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class)
            ->add('stock', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 0
                  ]
            ])
            ->add('imageFile1', VichImageType::class, [
                "required" => false,
                'delete_label' => 'Supprimer l\'image'
            ])
            ->add('imageFile2', VichImageType::class, [
                "required" => false,
                'delete_label' => 'Supprimer l\'image'
            ])
            ->add('imageFile3', VichImageType::class, [
                "required" => false,
                'delete_label' => 'Supprimer l\'image'
            ])
            ->add('size', EntityType::class, [
                'required' => false,
                'class' => Size::class,
                'choice_label' => 'name',
            ]
            )
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
