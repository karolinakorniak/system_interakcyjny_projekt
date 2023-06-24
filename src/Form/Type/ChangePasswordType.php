<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('newPassword',
                PasswordType::class,
                [
                    'label' => 'profile.labels.newPassword',
                    'required' => true,
                    'attr' => ['max_length' => 255, 'min_length' => 5]
                ]
            )->add('confirmPassword',
                PasswordType::class,
                [
                    'label' => 'profile.labels.confirmPassword',
                    'required' => true,
                    'attr' => ['max_length' => 255, 'min_length' => 5]
                ])
            ->add('oldPassword',
                PasswordType::class,
                [
                    'label' => 'profile.labels.oldPassword',
                    'required' => true,
                    'attr' => ['max_length' => 255, 'min_length' => 5]
                ]);
    }


}