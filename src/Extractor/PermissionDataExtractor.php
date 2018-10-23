<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Extractor;

use Sylius\RbacPlugin\Model\PermissionInterface;

final class PermissionDataExtractor implements PermissionDataExtractorInterface
{
    public function extract(array $permissions): array
    {
        $permissionTypes = [];

        /** @var PermissionInterface $permission */
        foreach ($permissions as $permission) {
            $permissionTypes[] = $permission->type();
        }

        return $permissionTypes;
    }
}
