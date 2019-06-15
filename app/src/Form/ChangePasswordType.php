<?php
/**
 * Change password type.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ChangePasswordType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
$builder->add('oldPassword', PasswordType::class);
$builder->add('newPassword', RepeatedType::class, [
'type' => PasswordType::class,
'invalid_message' => 'The password fields must match.',
'required' => true,
'first_options'  => array('label' => 'Password'),
'second_options' => array('label' => 'Repeat Password'),
]);
}

public function setDefaultOptions(OptionsResolverInterface $resolver)
{
$resolver->setDefaults(array(
    'data_class' => ChangePassword::class,
));
}

public function getName()
{
return 'change_passwd';
}
}