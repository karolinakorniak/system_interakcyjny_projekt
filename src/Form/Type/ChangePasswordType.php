<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChangePasswordType
 */
class ChangePasswordType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder The form builder
     * @param array<string, mixed> $options Form options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
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
