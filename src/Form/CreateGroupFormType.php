<?php

namespace App\Form;

use App\Entity\UsersGroup;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CreateGroupFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Group Name'
            ])
            ->add('users', EntityType::class,array(
                'class'=> User::class,
                'choices' => $options["users"],
                'expanded' => True,
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UsersGroup::class,
            'users' => [],
        ]);

        $resolver->setRequired('users');

        $resolver->setAllowedTypes('users', 'array');
    }
}