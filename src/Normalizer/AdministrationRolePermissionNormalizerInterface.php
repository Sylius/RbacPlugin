<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Normalizer;

interface AdministrationRolePermissionNormalizerInterface
{
    public function normalize(array $administrationRolePermissions): array;
}
