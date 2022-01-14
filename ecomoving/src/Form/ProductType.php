<?php

namespace App\Form;


use Symfony\Component\Form\FormBuilderInterface;


class ProductType extends BaseAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('status')
            ->add('category_id')
        ;
        $builder->setMethod('POST');
    }
}
