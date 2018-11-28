<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Factory;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionInterface;

final class AdministrationRoleFactorySpec extends ObjectBehavior
{
    function let(FactoryInterface $decoratedFactory): void
    {
        $this->beConstructedWith($decoratedFactory);
    }

    function it_implements_administration_role_factory_interface(): void
    {
        $this->shouldImplement(AdministrationRoleFactoryInterface::class);
    }

    function it_returns_new_administration_role(
        AdministrationRoleInterface $administrationRole,
        FactoryInterface $decoratedFactory
    ): void {
        $decoratedFactory->createNew()->willReturn($administrationRole);

        $this->createNew()->shouldReturn($administrationRole);
    }

    function it_returns_new_administration_role_with_name_and_permissions(
        AdministrationRoleInterface $administrationRole,
        FactoryInterface $decoratedFactory
    ): void {
        $administrationRole->setName('Product Manager')->shouldBeCalled();

        $administrationRole->addPermission(Argument::that(function (PermissionInterface $permission): bool {
            return
                $permission->type() === Permission::CONFIGURATION_PERMISSION &&
                $permission->operationTypes()[0] == OperationType::read()
            ;
        }))->shouldBeCalled();

        $administrationRole->addPermission(Argument::that(function (PermissionInterface $permission): bool {
            return
                $permission->type() === Permission::CATALOG_MANAGEMENT_PERMISSION &&
                $permission->operationTypes()[0] == OperationType::read()
            ;
        }))->shouldBeCalled();

        $decoratedFactory->createNew()->willReturn($administrationRole);

        $this->createWithNameAndPermissions(
            'Product Manager',
            [
                Permission::CONFIGURATION_PERMISSION => [OperationType::read()],
                Permission::CATALOG_MANAGEMENT_PERMISSION => [OperationType::read()],
            ]
        )->shouldReturn($administrationRole);
    }
}
