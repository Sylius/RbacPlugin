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
            $administrationRoleValidator
        );
    }

    function it_handles_command_and_updates_administration_role_with_given_id(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository,
        AdministrationRoleInterface $updatedAdministrationRole,
        AdministrationRoleInterface $administrationRoleUpdates,
        AdministrationRoleValidatorInterface $administrationRoleValidator
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

        $administrationRoleRepository->find(1)->willReturn($updatedAdministrationRole);

        $administrationRoleUpdates->getName()->willReturn('morty_smith');
        $administrationRoleUpdates
            ->getPermissions()
            ->willReturn([$salesManagementPermission, $customersManagementPermission])
        ;

        $administrationRoleFactory
            ->createWithNameAndPermissions('morty_smith', ['sales_management', 'customers_management'])
            ->willReturn($administrationRoleUpdates)
        ;

        $administrationRoleValidator->validate($administrationRoleUpdates)->shouldBeCalled();

        $updatedAdministrationRole->setName('morty_smith')->shouldBeCalled();

        $updatedAdministrationRole->clearPermissions()->shouldBeCalled();

        $updatedAdministrationRole->addPermission($salesManagementPermission)->shouldBeCalled();
        $updatedAdministrationRole->addPermission($customersManagementPermission)->shouldBeCalled();

        $administrationRoleManager->flush()->shouldBeCalled();

        $command = new UpdateAdministrationRole(
            1,
            'morty_smith',
            ['sales_management', 'customers_management']
        );

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
            ['catalog_management', 'configuration']
        );

        $administrationRoleFactory
            ->createWithNameAndPermissions('', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleValidator->validate($administrationRole)->willThrow(new \InvalidArgumentException());

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$command]);
    }
}
