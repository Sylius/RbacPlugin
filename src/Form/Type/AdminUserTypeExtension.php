<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Type;

use Sylius\Bundle\CoreBundle\Form\Type\User\AdminUserType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class AdminUserTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('administrationRole', AdministrationRoleChoiceType::class, [
            'required' => true,
        ]);
    }

    public function getExtendedType(): string
    {
        return AdminUserType::class;
    }
}
