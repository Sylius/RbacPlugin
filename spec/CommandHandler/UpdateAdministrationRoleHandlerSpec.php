<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionAccess;
use Sylius\RbacPlugin\Model\PermissionInterface;
use Sylius\RbacPlugin\Normalizer\AdministrationRolePermissionNormalizerInterface;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class UpdateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleValidatorInterface $administrationRoleValidator,
        AdministrationRolePermissionNormalizerInterface $administrationRolePermissionNormalizer
    ): void {
        $this->beConstructedWith(
            $administrationRoleManager,
            $administrationRoleFactory,
            $administrationRoleRepository,
            $administrationRoleValidator,
            $administrationRolePermissionNormalizer,
            'sylius_rbac_administration_role_update'
        );
    }

    function it_handles_command_and_updates_administration_role_with_given_id(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleInterface $updatedAdministrationRole,
        AdministrationRoleInterface $administrationRoleUpdates,
        AdministrationRoleValidatorInterface $administrationRoleValidator,
        AdministrationRolePermissionNormalizerInterface $administrationRolePermissionNormalizer,
        PermissionInterface $catalogManagementPermission,
        PermissionInterface $configurationPermission,
        PermissionInterface $salesManagementPermission,
        PermissionInterface $customersManagementPermission,
        PermissionInterface $normalizedSalesManagementPermission,
        PermissionInterface $normalizedCustomersManagementPermission
    ): void {
        $catalogManagementPermission->type()->willReturn(Permission::CATALOG_MANAGEMENT_PERMISSION);
        $catalogManagementPermission->accesses()->willReturn([PermissionAccess::READ, PermissionAccess::WRITE]);

        $configurationPermission->type()->willReturn(Permission::CONFIGURATION_PERMISSION);
        $catalogManagementPermission->accesses()->willReturn([PermissionAccess::READ]);

        $salesManagementPermission->type()->willReturn(Permission::SALES_MANAGEMENT_PERMISSION);
        $salesManagementPermission->accesses()->willReturn([PermissionAccess::READ, PermissionAccess::WRITE]);

        $customersManagementPermission->type()->willReturn(Permission::CONFIGURATION_PERMISSION);
        $customersManagementPermission->accesses()->willReturn([PermissionAccess::READ]);

        $command = new UpdateAdministrationRole(
            1,
            'morty_smith',
            [
                'sales_management' => [PermissionAccess::READ, PermissionAccess::WRITE],
                'customers_management' => [PermissionAccess::READ],
            ]
        );

        $administrationRoleFactory
            ->createWithNameAndPermissions('morty_smith', ['sales_management', 'customers_management'])
            ->willReturn($administrationRoleUpdates)
        ;

        $administrationRoleUpdates->getName()->willReturn('morty_smith');

        $administrationRoleUpdates
            ->getPermissions()
            ->willReturn(
                [
                    $salesManagementPermission,
                    $customersManagementPermission,
                ],
                [
                    $normalizedSalesManagementPermission,
                    $normalizedCustomersManagementPermission,
                ]
            )
        ;

        $administrationRoleValidator
            ->validate($administrationRoleUpdates, 'sylius_rbac_administration_role_update')
            ->shouldBeCalled()
        ;

        $administrationRolePermissionNormalizer
            ->normalize($salesManagementPermission)
            ->willReturn($normalizedSalesManagementPermission)
        ;

        $administrationRolePermissionNormalizer
            ->normalize($customersManagementPermission)
            ->willReturn($normalizedCustomersManagementPermission)
        ;

        $updatedAdministrationRole->getName()->willReturn('rick_sanchez');
        $updatedAdministrationRole
            ->getPermissions()
            ->willReturn([$catalogManagementPermission, $configurationPermission])
        ;

        $administrationRoleRepository->find(1)->willReturn($updatedAdministrationRole);

        $updatedAdministrationRole->setName('morty_smith')->shouldBeCalled();

        $updatedAdministrationRole->clearPermissions()->shouldBeCalled();

        $updatedAdministrationRole->addPermission($normalizedSalesManagementPermission)->shouldBeCalled();
        $updatedAdministrationRole->addPermission($normalizedCustomersManagementPermission)->shouldBeCalled();

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
            '',
            [
                'catalog_management' => [PermissionAccess::READ, PermissionAccess::WRITE],
                'configuration' => [PermissionAccess::READ],
            ]
        );

        $administrationRoleFactory
            ->createWithNameAndPermissions('', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleValidator
            ->validate($administrationRole, 'sylius_rbac_administration_role_update')
            ->willThrow(new \InvalidArgumentException())
        ;

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$command]);
    }

    function it_propagates_an_exception_when_administration_role_does_not_exist(
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleValidatorInterface $administrationRoleValidator,
        RepositoryInterface $administrationRoleRepository
    ): void {
        $administrationRoleFactory->createWithNameAndPermissions(
            'Product Manager',
            [Permission::CONFIGURATION_PERMISSION, Permission::CATALOG_MANAGEMENT_PERMISSION]
        )->willReturn($administrationRole);

        $administrationRoleValidator->validate($administrationRole)->shouldBeCalled();

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
