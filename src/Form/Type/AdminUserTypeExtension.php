<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\User\AdminUserType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

final class AdminUserTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('administrationRole', AdministrationRoleChoiceType::class, [
            'required' => false,
        ]);
    }

    public function getExtendedType()
    {
        return AdminUserType::class;
    }
}
