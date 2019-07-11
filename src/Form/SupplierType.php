<?php

namespace App\Form;

use App\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Supplier Name',
                'attr' => ['placeholder' => 'Supplier Name']
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'attr' => ['placeholder' => 'Adress'],
                'required' => false
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telephone',
                'attr' => ['placeholder' => '+XXXXXXXXXX or XXXXXXXX'],
                'required' => false
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'email'],
                'required' => false
            ])
            ->add('contactPerson', TextType::class, [
                'label' => 'Name',
                'attr' => ['placeholder' => 'Person of contact'],
                'required' => false
            ])
            ->add('local')
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary float-right'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}
