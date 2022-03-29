<?php


namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class PacksType extends BaseAbstractType

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
            ->add('duration')
            ->add('price')
            ->add('status')
        ;
        $builder->setMethod(self::$method);
    }

}