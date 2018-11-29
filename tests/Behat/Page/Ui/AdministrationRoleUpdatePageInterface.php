<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface;

interface AdministrationRoleUpdatePageInterface extends UpdatePageInterface
{
    public function addPermission(string $permissionName, array $operationTypes): void;

    public function removePermission(string $permissionName): void;

    public function removePermissionAccess(string $permissionName, string $operationType): void;

    public function isPermissionManageable(string $permissionName): bool;

    public function hasActiveOperationType(string $permissionName, string $operationType): bool;

    public function hasPermissionWithAccessSelected(string $permissionName, string $operationType): bool;
}
