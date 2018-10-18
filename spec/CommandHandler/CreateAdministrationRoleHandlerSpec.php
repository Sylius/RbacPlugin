<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;

final class CreateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator
    ): void {
        $this->beConstructedWith($administrationRoleManager, $administrationRoleCreator);
    }

    function it_handles_command_and_persists_new_administration_role(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        AdministrationRoleInterface $administrationRole
    ): void {
        $catalogManagementPermission = new Permission('catalog_management');
        $configurationPermission = new Permission('configuration');

        $administrationRole->getName()->willReturn('rick_sanchez');
        $administrationRole->getPermissions()->willReturn([$catalogManagementPermission, $configurationPermission]);

        $administrationRoleCreator
            ->create('rick_sanchez', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleManager->persist($administrationRole)->shouldBeCalled();
        $administrationRoleManager->flush()->shouldBeCalled();

        $command = new CreateAdministrationRole(
            'rick_sanchez',
            ['catalog_management', 'configuration']
        );

        $this->__invoke($command);
    }
}
