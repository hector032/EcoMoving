<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CategoryType extends BaseAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('description',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('status',CheckboxType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('created_at',TextType::class, ['required'=>false])
            ->add('updated_at',TextType::class, ['required'=>false])
            ->add('deleted_at',TextType::class, ['required'=>false])
            ->setMethod('POST')
        ;
    }
/*
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }*/
}
