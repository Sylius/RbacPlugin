<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionInterface;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class UpdateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $this->beConstructedWith(
            $administrationRoleManager,
            $administrationRoleFactory,
            $administrationRoleRepository,
            $administrationRoleValidator,
            'sylius_rbac_admin_administration_role_update'
        );
    }

    function it_handles_command_and_updates_administration_role_with_given_id(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleInterface $updatedAdministrationRole,
        AdministrationRoleInterface $administrationRoleUpdates,
        AdministrationRoleValidatorInterface $administrationRoleValidator,
        PermissionInterface $salesManagementPermission,
        PermissionInterface $customersManagementPermission
    ): void {
        $salesManagementPermission->type()->willReturn(Permission::SALES_MANAGEMENT_PERMISSION);
        $salesManagementPermission->operationTypes()->willReturn([OperationType::READ, OperationType::WRITE]);

        $customersManagementPermission->type()->willReturn(Permission::CONFIGURATION_PERMISSION);
        $customersManagementPermission->operationTypes()->willReturn([OperationType::READ]);

        $command = new UpdateAdministrationRole(
            1,
            'Sales Manager',
            [
                'sales_management' => [OperationType::READ, OperationType::WRITE],
                'customers_management' => [OperationType::READ],
            ]
        );

        $administrationRoleFactory
            ->createWithNameAndPermissions('Sales Manager',
                [
                    'sales_management' => [OperationType::READ, OperationType::WRITE],
                    'customers_management' => [OperationType::READ],
                ]
            )->willReturn($administrationRoleUpdates)
        ;

        $administrationRoleUpdates->getName()->willReturn('Sales Manager');

        $administrationRoleUpdates
            ->getPermissions()
            ->willReturn([$salesManagementPermission, $customersManagementPermission])
        ;

        $administrationRoleValidator
            ->validate($administrationRoleUpdates, 'sylius_rbac_admin_administration_role_update')
            ->shouldBeCalled()
        ;

        $updatedAdministrationRole->getName()->willReturn('Product Manager');
        $updatedAdministrationRole->clearPermissions()->shouldBeCalled();

        $administrationRoleRepository->find(1)->willReturn($updatedAdministrationRole);

        $updatedAdministrationRole->setName('Sales Manager')->shouldBeCalled();

        $updatedAdministrationRole->clearPermissions()->shouldBeCalled();

        $updatedAdministrationRole->addPermission($salesManagementPermission)->shouldBeCalled();
        $updatedAdministrationRole->addPermission($customersManagementPermission)->shouldBeCalled();

        $administrationRoleManager->flush()->shouldBeCalled();

        $this->__invoke($command);
    }

    function it_propagates_an_exception_when_administration_role_is_not_valid(
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $command = new UpdateAdministrationRole(
            1,
            'Product Manager',
            [
                'catalog_management' => [OperationType::READ, OperationType::WRITE],
                'configuration' => [OperationType::READ],
            ]
        );

        $administrationRoleFactory
            ->createWithNameAndPermissions(
                'Product Manager',
                [
                    'catalog_management' => [OperationType::READ, OperationType::WRITE],
                    'configuration' => [OperationType::READ],
                ]
            )->willReturn($administrationRole);

        $administrationRoleValidator
            ->validate($administrationRole, 'sylius_rbac_admin_administration_role_update')
            ->willThrow(new \InvalidArgumentException())
        ;

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$command]);
    }

    function it_propagates_an_exception_when_administration_role_does_not_exist(
        RepositoryInterface $administrationRoleRepository
    ): void {
        $administrationRoleRepository->find(1)->willReturn(null);

        $this->shouldThrow(\InvalidArgumentException::class)->during(
            '__invoke',
            [
                new UpdateAdministrationRole(
                1,
                'Product Manager',
                [Permission::CONFIGURATION_PERMISSION, Permission::CATALOG_MANAGEMENT_PERMISSION]),
            ]
        );
    }
}
