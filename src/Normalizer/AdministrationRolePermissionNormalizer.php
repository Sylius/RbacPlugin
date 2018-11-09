<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Normalizer;

use Sylius\RbacPlugin\Access\Model\OperationType;

final class AdministrationRolePermissionNormalizer implements AdministrationRolePermissionNormalizerInterface
{
    public function normalize(array $administrationRolePermissions = []): array
    {
        $normalizedPermissions = [];

        foreach (array_keys($administrationRolePermissions) as $administrationRolePermission) {
            $hasReadOperationType = in_array(
                OperationType::READ,
                array_keys($administrationRolePermissions[$administrationRolePermission])
            );

            $hasWriteOperationType = in_array(
                OperationType::WRITE,
                array_keys($administrationRolePermissions[$administrationRolePermission])
            );

            if ($hasWriteOperationType) {
                $normalizedPermissions[$administrationRolePermission][] = OperationType::read();
                $normalizedPermissions[$administrationRolePermission][] = OperationType::write();

                continue;
            }

            if ($hasReadOperationType) {
                $normalizedPermissions[$administrationRolePermission][] = OperationType::read();
            }
        }

        return $normalizedPermissions;
    }
}
