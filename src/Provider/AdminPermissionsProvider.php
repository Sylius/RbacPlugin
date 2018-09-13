<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

final class AdminPermissionsProvider implements AdminPermissionsProviderInterface
{
    private const CATALOG_MANAGEMENT_PERMISSION = 'catalog_management';
    private const CONFIGURATION_PERMISSION = 'configuration';
    private const CUSTOMERS_MANAGEMENT_PERMISSION = 'customers_management';
    private const MARKETING_MANAGEMENT_PERMISSION = 'marketing_management';
    private const SALES_MANAGEMENT_PERMISSION = 'sales_management';

    /** @return array|string[] */
    public function __invoke(): array
    {
        return [
            self::CATALOG_MANAGEMENT_PERMISSION,
            self::CONFIGURATION_PERMISSION,
            self::CUSTOMERS_MANAGEMENT_PERMISSION,
            self::MARKETING_MANAGEMENT_PERMISSION,
            self::SALES_MANAGEMENT_PERMISSION,
        ];
    }
}
