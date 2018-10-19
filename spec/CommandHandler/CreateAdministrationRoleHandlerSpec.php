<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class CreateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $this->beConstructedWith($administrationRoleManager, $administrationRoleCreator, $administrationRoleValidator);
    }

    function it_handles_command_and_persists_new_administration_role(
        ObjectManager $administrationRoleManager,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $catalogManagementPermission = new Permission('catalog_management');
        $configurationPermission = new Permission('configuration');

        $administrationRole->getName()->willReturn('rick_sanchez');
        $administrationRole->getPermissions()->willReturn([$catalogManagementPermission, $configurationPermission]);

        $administrationRoleCreator
            ->create('rick_sanchez', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleValidator->validate($administrationRole)->shouldBeCalled();

        $administrationRoleManager->persist($administrationRole)->shouldBeCalled();
        $administrationRoleManager->flush()->shouldBeCalled();

        $command = new CreateAdministrationRole(
            'rick_sanchez',
            ['catalog_management', 'configuration']
        );

        $this->__invoke($command);
    }

    function it_propagates_an_exception_when_administration_role_is_not_valid(
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleCreatorInterface $administrationRoleCreator,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $command = new CreateAdministrationRole(
            '',
            ['catalog_management', 'configuration']
        );

        $administrationRoleCreator
            ->create('', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleValidator->validate($administrationRole)->willThrow(new \InvalidArgumentException());

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$command]);
    }
}
