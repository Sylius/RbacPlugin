<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Normalizer;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionAccess;
use Sylius\RbacPlugin\Normalizer\AdministrationRolePermissionNormalizerInterface;

final class AdministrationRolePermissionNormalizerSpec extends ObjectBehavior
{
    function it_implements_administration_role_permissions_normalizer_interface(): void
    {
        $this->shouldImplement(AdministrationRolePermissionNormalizerInterface::class);
    }

    function it_adds_read_access_to_administration_role_when_only_write_access_is_added(): void
    {
        $permission = Permission::customerManagement([PermissionAccess::WRITE]);

        $normalizedPermissionAccesses = [
                PermissionAccess::WRITE,
                PermissionAccess::READ,
            ]
        ;

        $this->normalize($permission)->accesses()->shouldBeLike($normalizedPermissionAccesses);
    }
}
