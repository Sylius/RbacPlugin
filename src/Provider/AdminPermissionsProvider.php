<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionAccess;

final class AdminPermissionsProvider implements AdminPermissionsProviderInterface
{
    /** @return array|string[] */
    public function getPossiblePermissions(): array
    {
        return [
            Permission::CATALOG_MANAGEMENT_PERMISSION,
            Permission::CONFIGURATION_PERMISSION,
            Permission::CUSTOMERS_MANAGEMENT_PERMISSION,
            Permission::MARKETING_MANAGEMENT_PERMISSION,
            Permission::SALES_MANAGEMENT_PERMISSION,
        ];
    }
}
