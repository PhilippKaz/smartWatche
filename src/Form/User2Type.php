<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,
                [
                    'label' => 'Имя пользователя',
                    'attr' => [
                        'placeholder' => 'Введите имя пользователя',
                        'class' => 'wrap-input100'
                    ]
                ])

            ->add('email', TextType::class,
                [
                    'label' => 'Электронная почта',
                    'attr' => [
                        'placeholder' => 'Введите электронную почту',
                        'class' => 'wrap-input100'
                    ]
                ])

            ->add('password', TextType::class,
                [
                    'label' => 'Пароль',
                    'attr' => [
                        'placeholder' => 'Введите пароль',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('lastLogin', DateTimeType::class,
                [
                    'label' => 'Последняя авторизация',
                    'attr' => [
                        'placeholder' => 'Введите дату и время последней авторизации',
                        'class' => 'wrap-input100'
                    ]
                ])

            ->add('roles', CollectionType::class,
                [
                    'label' => 'Роль',
                    'attr' => [
                        'placeholder' => 'Введите роль',
                        'class' => 'wrap-input100'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
