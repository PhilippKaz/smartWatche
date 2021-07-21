<?php

namespace App\Form;

use App\Entity\Project;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Project1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idd', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class,
            [
                'label' => 'Код проекта',
                'attr' => [
                    'placeholder' => 'Введите код проекта',
                    'class' => 'wrap-input100'
            ]])

            ->add('title', TextType::class,
            [
                'label' => 'Наименование проекта',
                'attr' => [
                    'placeholder' => 'Введите наименование проекта',
                    'class' => 'wrap-input100'
            ]])

            ->add('updated_at', TextType::class,
            [
                'label' => 'Создано',
                'attr' => [
                    'placeholder' => 'Введите когда проект был создан',
                    'class' => 'wrap-input100'
            ]])

            ->add('cover', TextType::class,
            [
                'label' => 'Ссылка на заставку',
                'attr' => [
                    'placeholder' => 'Введите ссылку на заставку',
                    'class' => 'wrap-input100'
            ]])

            ->add('category', TextType::class,
            [
                'label' => 'Категории',
                'attr' => [
                    'placeholder' => 'Введите категорию проекта',
                    'class' => 'wrap-input100'
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
