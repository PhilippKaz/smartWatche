<?php

namespace App\Form;

use App\Entity\Category;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class,
                [
                    'label' => 'Код категории',
                    'attr' => [
                        'placeholder' => 'Введите код категории',
                        'class' => 'wrap-input100'
                    ]
                ])
            ->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Наименование',
                    'attr' => [
                        'placeholder' => 'Введите наименование категории',
                        'class' => 'wrap-input100'
                    ]
                ])


            ->add('src', \Symfony\Component\Form\Extension\Core\Type\TextType::class,
                [
                    'label' => 'Заставка',
                    'attr' => [
                        'placeholder' => 'Введите ссылку на заставку',
                        'class' => 'wrap-input100'
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
