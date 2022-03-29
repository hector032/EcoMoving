<?php

namespace App\Form;


use Symfony\Component\Form\FormBuilderInterface;


class ProductType extends BaseAbstractType
{
    public static $method;

    public static function setMethod(String $method)
    {
        self::$method = $method;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('status')
            ->add('category_id');

        $builder->setMethod(self::$method);
    }
}
