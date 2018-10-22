<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Extractor;

use Sylius\RbacPlugin\Model\PermissionAccess;

final class RequestAdministrationRolePermissionsExtractor implements RequestAdministrationRolePermissionsExtractorInterface
{
    public function extract(array $requestParameters): array
    {
        $permissions = [[]];

        foreach (array_keys($requestParameters) as $parameterKey)
        {
            if (!(
                strpos($parameterKey, PermissionAccess::READ) ||
                strpos($parameterKey, PermissionAccess::WRITE)
            )) {
                continue;
            }

            $permissionWithAccess = explode(PermissionAccess::PERMISSION_ACCESS_DELIMITER, $parameterKey);

            if (!array_key_exists($permissionWithAccess[0], $permissions)) {
                $permissions[$permissionWithAccess[0]] = [];
            }

            array_push($permissions[$permissionWithAccess[0]], $permissionWithAccess[1]);
        }

        return $permissions;
    }
}
