<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Factory\AdministrationRoleFactoryInterface;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionAccess;
use Sylius\RbacPlugin\Model\PermissionInterface;
use Sylius\RbacPlugin\Normalizer\AdministrationRolePermissionNormalizerInterface;
use Sylius\RbacPlugin\Validator\AdministrationRoleValidatorInterface;

final class CreateAdministrationRoleHandlerSpec extends ObjectBehavior
{
    function let(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRolePermissionNormalizerInterface $administrationRolePermissionNormalizer,
        AdministrationRoleValidatorInterface $administrationRoleValidator
    ): void {
        $this->beConstructedWith(
            $administrationRoleManager,
            $administrationRoleFactory,
            $administrationRoleValidator,
            $administrationRolePermissionNormalizer
        );
    }

    function it_handles_command_and_persists_new_administration_role(
        ObjectManager $administrationRoleManager,
        AdministrationRoleFactoryInterface $administrationRoleFactory,
        AdministrationRoleInterface $administrationRole,
        AdministrationRoleValidatorInterface $administrationRoleValidator,
        AdministrationRolePermissionNormalizerInterface $administrationRolePermissionNormalizer,
        PermissionInterface $catalogManagementPermission,
        PermissionInterface $configurationPermission
    ): void {
        $catalogManagementPermission->type()->willReturn(Permission::CATALOG_MANAGEMENT_PERMISSION);
        $catalogManagementPermission->accesses()->willReturn([PermissionAccess::READ]);

        $configurationPermission->type()->willReturn(Permission::CONFIGURATION_PERMISSION);
        $configurationPermission->accesses()->willReturn([PermissionAccess::READ]);

        $administrationRole->getName()->willReturn('Product Manager');
        $administrationRole->getPermissions()->willReturn([Permission::catalogManagement(), Permission::configuration()]);

        $administrationRoleFactory
            ->createWithNameAndPermissions('Product Manager', ['catalog_management', 'configuration'])
            ->willReturn($administrationRole)
        ;

        $administrationRoleValidator->validate($administrationRole)->shouldBeCalled();

        $administrationRolePermissionNormalizer->normalize($catalogManagementPermission)->shouldBeCalled();
        $administrationRolePermissionNormalizer->normalize($configurationPermission)->shouldBeCalled();

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
            [
                'catalog_management' => [PermissionAccess::READ],
                'configuration' => [PermissionAccess::READ],
            ]
        );

        $administrationRoleFactory
            ->createWithNameAndPermissions('', ['catalog_management', 'configuration']);

        $administrationRoleValidator->validate($administrationRole)->willThrow(new \InvalidArgumentException());

        $this->shouldThrow(\InvalidArgumentException::class)->during('__invoke', [$command]);
    }
}
