<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;

final class UpdateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        RepositoryInterface $administrationRoleRepository
    ): void {
        $this->beConstructedWith($administrationRoleManager, $administrationRoleCreator, $administrationRoleRepository);
    }

    function it_handles_command_and_updates_administration_role_with_given_id(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleInterface $updatedAdministrationRole,
        AdministrationRoleInterface $administrationRoleUpdates
    ): void {
        $catalogManagementPermission = new Permission('catalog_management');
        $configurationPermission = new Permission('configuration');
        $salesManagementPermission = new Permission('sales_management');
        $customersManagementPermission = new Permission('customers_management');

        $updatedAdministrationRole->getName()->willReturn('rick_sanchez');
        $updatedAdministrationRole
            ->getPermissions()
            ->willReturn([$catalogManagementPermission, $configurationPermission])
        ;

        $administrationRoleRepository->find('1')->willReturn($updatedAdministrationRole);

        $administrationRoleUpdates->getName()->willReturn('morty_smith');
        $administrationRoleUpdates
            ->getPermissions()
            ->willReturn([$salesManagementPermission, $customersManagementPermission])
        ;

        $administrationRoleCreator
            ->create('morty_smith', ['sales_management', 'customers_management'])
            ->willReturn($administrationRoleUpdates)
        ;

        $updatedAdministrationRole->setName('morty_smith')->shouldBeCalled();

        $updatedAdministrationRole->removePermission($catalogManagementPermission)->shouldBeCalled();
        $updatedAdministrationRole->removePermission($configurationPermission)->shouldBeCalled();

        $updatedAdministrationRole->addPermission($salesManagementPermission)->shouldBeCalled();
        $updatedAdministrationRole->addPermission($customersManagementPermission)->shouldBeCalled();

        $administrationRoleManager->persist($updatedAdministrationRole)->shouldBeCalled();
        $administrationRoleManager->flush()->shouldBeCalled();

        $command = new UpdateAdministrationRole(
            '1',
            'morty_smith',
            ['sales_management', 'customers_management']
        );

        $this->__invoke($command);
    }
}
