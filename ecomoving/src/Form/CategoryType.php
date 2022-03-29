<?php

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class CategoryType extends BaseAbstractType
{
    public static $method;

    public static function setMethod(String $method)
    {
        self::$method = $method;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('description',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('status',CheckboxType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])

        ;
        $builder->setMethod(self::$method);
    }
}
