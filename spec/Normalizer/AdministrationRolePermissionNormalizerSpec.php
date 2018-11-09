<?php

declare(strict_types=1);

namespace spec\Sylius\RbacPlugin\Normalizer;

use PhpSpec\ObjectBehavior;
use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Normalizer\AdministrationRolePermissionNormalizerInterface;

final class AdministrationRolePermissionNormalizerSpec extends ObjectBehavior
{
    function it_implements_administration_role_permissions_normalizer_interface(): void
    {
        $this->shouldImplement(AdministrationRolePermissionNormalizerInterface::class);
    }

    function it_adds_read_access_to_administration_role_when_only_write_access_is_added(): void
    {
        $operationTypes = [Permission::CATALOG_MANAGEMENT_PERMISSION => [OperationType::WRITE => 'on']];

        $normalizedPermissionOperationTypes = [
            Permission::CATALOG_MANAGEMENT_PERMISSION => [
                OperationType::READ,
                OperationType::WRITE,
            ],
        ];

        $this->normalize($operationTypes)->shouldBeLike($normalizedPermissionOperationTypes);
    }
}
