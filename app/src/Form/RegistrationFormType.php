<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'fullName',
            TextType::class,
            [
                'label' => 'label.fullname',
                'required' => true,
                'attr' => ['max_length' => 45]
            ]
        );
        $builder->add('email',
            EmailType::class,
            [
                'label' => 'Email',
                'required' => true,
            ]
        );
        $builder->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'first_options'  => ['label' => 'Hasło'],
            'second_options' => ['label' => 'Powtórz hasło'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {


        $resolver->setDefaults([
            'validation_groups' => ['register'],
        ]);
    }
    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string The prefix of the template block name
     */
    public function getBlockPrefix(): string
    {
        return 'user';
    }
}