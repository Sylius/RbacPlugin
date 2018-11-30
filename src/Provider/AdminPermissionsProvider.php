<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

use Sylius\RbacPlugin\Model\Permission;

final class AdminPermissionsProvider implements AdminPermissionsProviderInterface
{
    /** @var array */
    private $rbacConfiguration;

    public function __construct(array $rbacConfiguration)
    {
        $configuration = [];
        foreach ($rbacConfiguration['custom'] as $customSection => $customRoutes) {
            $configuration[$customSection] = $configuration;
        }

        $rbacConfiguration = array_merge(
            array_keys($configuration),
            [
                Permission::CATALOG_MANAGEMENT_PERMISSION,
                Permission::CONFIGURATION_PERMISSION,
                Permission::CUSTOMERS_MANAGEMENT_PERMISSION,
                Permission::MARKETING_MANAGEMENT_PERMISSION,
                Permission::SALES_MANAGEMENT_PERMISSION,
            ]
        );

        sort($rbacConfiguration);

        $this->rbacConfiguration = $rbacConfiguration;
    }

    /** @return array|string[] */
    public function getPossiblePermissions(): array
    {
        return $this->rbacConfiguration;
    }
}
