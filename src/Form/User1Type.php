<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('usernameCanonical', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('email', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('emailCanonical', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('enabled', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('salt', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('password', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('lastLogin', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('confirmationToken', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('passwordRequestedAt', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])

            ->add('roles', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
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
