<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Access\Checker;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Checker\AdministratorAccessCheckerInterface;
use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;
use Tests\Application\RbacPlugin\Entity\AdminUser;

final class AdministratorAccessCheckerSpec extends ObjectBehavior
{
    function it_implements_administrator_access_checker_interface(): void
    {
        $this->shouldImplement(AdministratorAccessCheckerInterface::class);
    }

    function it_returns_false_if_admin_is_not_allowed_to_read_access_requested_section(
        AdminUser $admin,
        AdministrationRoleInterface $administrationRole
    ): void {
        $admin->getAdministrationRole()->willReturn($administrationRole);

        $administrationRole->getPermissions()->willReturn([
            Permission::configuration([OperationType::read(), OperationType::write()]),
        ]);

        $this
            ->canAccessSection($admin, new AccessRequest(Section::catalog(), OperationType::read()))
            ->shouldReturn(false)
        ;
    }

    function it_returns_false_if_admin_is_not_allowed_to_write_access_requested_section(
        AdminUser $admin,
        AdministrationRoleInterface $administrationRole
    ): void {
        $admin->getAdministrationRole()->willReturn($administrationRole);

        $administrationRole->getPermissions()->willReturn([
            Permission::configuration([OperationType::read(), OperationType::write()]),
            Permission::catalogManagement([OperationType::read()]),
        ]);

        $this
            ->canAccessSection($admin, new AccessRequest(Section::catalog(), OperationType::write()))
            ->shouldReturn(false)
        ;
    }

    function it_returns_true_if_admin_is_allowed_to_read_access_requested_section(
        AdminUser $admin,
        AdministrationRoleInterface $administrationRole
    ): void {
        $admin->getAdministrationRole()->willReturn($administrationRole);

        $administrationRole->getPermissions()->willReturn([
            Permission::configuration([OperationType::read(), OperationType::write()]),
            Permission::catalogManagement([OperationType::read()]),
        ]);

        $this
            ->canAccessSection($admin, new AccessRequest(Section::catalog(), OperationType::read()))
            ->shouldReturn(true)
        ;
    }

    function it_returns_true_if_admin_is_allowed_to_write_access_requested_section(
        AdminUser $admin,
        AdministrationRoleInterface $administrationRole
    ): void {
        $admin->getAdministrationRole()->willReturn($administrationRole);

        $administrationRole->getPermissions()->willReturn([
            Permission::configuration([OperationType::read(), OperationType::write()]),
            Permission::catalogManagement([OperationType::read(), OperationType::write()]),
        ]);

        $this
            ->canAccessSection($admin, new AccessRequest(Section::catalog(), OperationType::write()))
            ->shouldReturn(true)
        ;
    }

    function it_returns_true_if_admin_is_allowed_to_access_requested_custom_section(
        AdminUser $admin,
        AdministrationRoleInterface $administrationRole
    ): void {
        $admin->getAdministrationRole()->willReturn($administrationRole);

        $administrationRole->getPermissions()->willReturn([Permission::ofType('custom_section', [OperationType::read(), OperationType::write()])]);

        $this->canAccessSection($admin, new AccessRequest(Section::ofType('custom_section'), OperationType::write()))->shouldReturn(true);
    }
}
