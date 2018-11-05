<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Normalizer;

use Sylius\RbacPlugin\Access\Model\OperationType;
use Sylius\RbacPlugin\Model\PermissionInterface;

final class AdministrationRolePermissionNormalizer implements AdministrationRolePermissionNormalizerInterface
{
    public function normalize(PermissionInterface $permission): PermissionInterface
    {
        if (
            in_array(OperationType::WRITE, $permission->operationTypes()) &&
            !in_array(OperationType::READ, $permission->operationTypes())
        ) {
            $permission->addOperationType(OperationType::READ);
        }

        return $permission;
    }
}
