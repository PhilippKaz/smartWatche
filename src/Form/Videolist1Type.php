<?php

namespace App\Form;

use App\Entity\Videolist;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Videolist1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Наименование видео',
                    'attr' => [
                        'placeholder' => 'Введите наименование видео',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('description',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Описание',
                    'attr' => [
                        'placeholder' => 'Введите описание видео',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('created',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Дата создания видео',
                    'attr' => [
                        'placeholder' => '',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('cover',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Заставка видео',
                    'attr' => [
                        'placeholder' => 'Введите ссылку на заставку',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('added',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Дата добавления',
                    'attr' => [
                        'placeholder' => 'Введите дату добавления',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('user',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Пользователь',
                    'attr' => [
                        'placeholder' => 'Введите пользователя, добавивший видео',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('video',
                \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Код видео',
                    'attr' => [
                        'placeholder' => 'Введите код видео',
                        'class' => 'wrap-input100'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Videolist::class,
        ]);
    }
}
