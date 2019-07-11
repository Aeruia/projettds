<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\SubCategory;
use App\Entity\Supplier;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
                'attr' => ['placeholder' => 'Product Name']
            ])
            ->add(
                'unit',
                TextType::class,
                [
                    'label' => 'Unit of mesure',
                    'attr' => ['placeholder' => 'Unit Name']
                ]
            )
            ->add(
                'package',
                TextType::class,
                ['attr' => ['placeholder' => 'Packaging']]
            )
            ->add('stock')
            ->add('price')
            ->add('idsubcategory', EntityType::class, [
                'class' => SubCategory::class,
                'required' => false
            ])
            ->add('iduser', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
                'required' => false
            ])
            ->add('duedate', DateType::class)
            ->add('idsupplier', EntityType::class, [
                'class' => Supplier::class,
                'required' => false
            ])
            ->add('bio')
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
