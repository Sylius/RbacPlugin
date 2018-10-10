<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface;

interface AdministrationRoleUpdatePageInterface extends UpdatePageInterface
{
    public function addPermission(string $permissionName, array $accesses): void;

    public function removePermission(string $permissionName): void;

    public function removePermissionWithAccess($permissionName, $access): void;

    public function hasPermissionToSelect(string $permissionName): bool;

    public function hasPermissionSelected(string $permissionName): bool;

    public function hasPermissionWithAccessSelected(string $permissionName, string $access): bool;
}
