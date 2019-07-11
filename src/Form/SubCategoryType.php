<?php

namespace App\Form;

use App\Entity\SubCategory;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Subcategory Name'
            ])
            ->add('idcategory', EntityType::class, [
                'class' => Category::class,
                'label' => 'Category'
            ])
            ->add('idUser', EntityType::class, [
                'class' => User::class,
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'label' => 'Gestionaire'
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }
}
