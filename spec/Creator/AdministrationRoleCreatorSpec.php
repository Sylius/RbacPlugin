<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Creator;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Creator\AdministrationRoleCreatorInterface;
use Sylius\RbacPlugin\Entity\AdministrationRole;
use Sylius\RbacPlugin\Model\Permission;

final class AdministrationRoleCreatorSpec extends ObjectBehavior
{
    function it_implements_administration_role_creator_interface(): void
    {
        $this->shouldImplement(AdministrationRoleCreatorInterface::class);
    }

    function it_creates_new_administration_role_based_on_given_parameters(): void
    {
        $administrationRole = new AdministrationRole();
        $administrationRole->setName('rick_sanchez');

        $administrationRole->addPermission(new Permission('catalog_management'));
        $administrationRole->addPermission(new Permission('configuration'));

        $this
            ->create('rick_sanchez', ['catalog_management', 'configuration'])
            ->shouldBeLike($administrationRole)
        ;
    }
}
