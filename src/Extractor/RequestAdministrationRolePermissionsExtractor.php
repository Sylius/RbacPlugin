<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Extractor;

use Sylius\RbacPlugin\Model\PermissionAccess;

final class RequestAdministrationRolePermissionsExtractor implements RequestAdministrationRolePermissionsExtractorInterface
{
    public function extract(array $requestParameters): array
    {
        $permissions = [];

        foreach (array_keys($requestParameters) as $parameterKey) {
            if (!(
                strpos($parameterKey, PermissionAccess::READ) !== false ||
                strpos($parameterKey, PermissionAccess::WRITE) !== false
            )) {
                continue;
            }

            $permissionWithAccess = explode(PermissionAccess::PERMISSION_ACCESS_DELIMITER, $parameterKey);

            if (!array_key_exists($permissionWithAccess[1], $permissions)) {
                $permissions[$permissionWithAccess[1]] = [];
            }

            $permissions[$permissionWithAccess[1]][] = $permissionWithAccess[0];
        }

        return $permissions;
    }
}
