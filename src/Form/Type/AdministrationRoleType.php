<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class AdministrationRoleType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['label' => 'sylius.ui.name']);
    }

    public function getBlockPrefix()
    {
        return 'sylius_rbac_administration_role';
    }
}
