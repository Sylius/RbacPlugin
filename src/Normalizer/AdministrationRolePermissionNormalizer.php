<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Normalizer;

use Sylius\RbacPlugin\Model\PermissionAccess;
use Sylius\RbacPlugin\Model\PermissionInterface;

final class AdministrationRolePermissionNormalizer implements AdministrationRolePermissionNormalizerInterface
{
    public function normalize(PermissionInterface $permission): PermissionInterface
    {
        if (
            in_array(PermissionAccess::WRITE, $permission->accesses()) &&
            !in_array(PermissionAccess::READ, $permission->accesses())
        ) {
            $permission->addAccess(PermissionAccess::READ);
        }

        return $permission;
    }
}
