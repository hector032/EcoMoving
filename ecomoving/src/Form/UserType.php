<?php

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserType extends BaseAbstractType
{
    public static $method;

    public static function setMethod(String $method)
    {
        self::$method = $method;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('lastName',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('address',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('country',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('city',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('zip_code',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('phone',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('role_id',TextType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
            ->add('status',CheckboxType::class, ['required'=>true,'constraints'=>[new NotNull(),new NotBlank()]])
        ;
        $builder->setMethod(self::$method);
    }

}

