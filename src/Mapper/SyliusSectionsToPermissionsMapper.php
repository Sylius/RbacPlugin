<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Mapper;

use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Model\Permission;

final class SyliusSectionsToPermissionsMapper implements SectionsToPermissionsMapperInterface
{
    /** @var array */
    private $sectionsToPermissionsMapping;

    public function __construct()
    {
        $this->sectionsToPermissionsMapping = [
            Section::CATALOG => Permission::CATALOG_MANAGEMENT_PERMISSION,
            Section::SALES => Permission::SALES_MANAGEMENT_PERMISSION,
            Section::MARKETING => Permission::MARKETING_MANAGEMENT_PERMISSION,
            Section::CUSTOMERS => Permission::CUSTOMERS_MANAGEMENT_PERMISSION,
            Section::CONFIGURATION => Permission::CONFIGURATION_PERMISSION
        ];
    }

    public function map(string $section): string
    {
        if (array_key_exists($section, $this->sectionsToPermissionsMapping)) {
            return $this->sectionsToPermissionsMapping[$section];
        }

        return $section;
    }
}
