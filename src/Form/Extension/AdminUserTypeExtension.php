<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Form\Extension;

use Sylius\Bundle\CoreBundle\Form\Type\User\AdminUserType;
use Sylius\RbacPlugin\Form\Type\AdministrationRoleChoiceType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method iterable getExtendedTypes()
 */
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
