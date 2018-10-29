<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class CreateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $this->beConstructedWith($administrationRoleManager, $administrationRoleFactory, $administrationRoleValidator);
    }

    function it_handles_command_and_persists_new_administration_role(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $administrationRole->getName()->willReturn('Product Manager');
        $administrationRole->getPermissions()->willReturn([Permission::catalogManagement(), Permission::configuration()]);

        $administrationRoleFactory
            ->createWithNameAndPermissions('Product Manager', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleValidator->validate($administrationRole)->shouldBeCalled();

        $administrationRoleManager->persist($administrationRole)->shouldBeCalled();
        $administrationRoleManager->flush()->shouldBeCalled();

        $this->__invoke(new CreateAdministrationRole(
            'Product Manager',
            ['catalog_management', 'configuration']
        ));
    }

    function it_propagates_an_exception_when_administration_role_is_not_valid(
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $command = new CreateAdministrationRole(
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
