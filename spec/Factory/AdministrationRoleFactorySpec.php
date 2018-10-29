<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Factory;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Entity\AdministrationRole;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\Permission;

final class AdministrationRoleFactorySpec extends ObjectBehavior
{
    function it_implements_administration_role_factory_interface(): void
    {
        $this->shouldImplement(AdministrationRoleFactoryInterface::class);
    }

    function it_returns_new_administration_role(): void
    {
        $this->createNew()->shouldBeLike(new AdministrationRole());
    }

    function it_returns_new_administration_role_with_name_and_permissions(): void
    {
        $administrationRole = new AdministrationRole();
        $administrationRole->setName('Product Manager');
        $administrationRole->addPermission(Permission::configuration());
        $administrationRole->addPermission(Permission::catalogManagement());

        $this->createWithNameAndPermissions(
            'Product Manager',
            [
                Permission::CONFIGURATION_PERMISSION,
                Permission::CATALOG_MANAGEMENT_PERMISSION,
            ]
        )->shouldBeLike($administrationRole);
    }
}
