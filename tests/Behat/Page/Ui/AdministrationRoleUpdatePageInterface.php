<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface;

interface AdministrationRoleUpdatePageInterface extends UpdatePageInterface
{
    public function addPermission(string $permissionName): void;

    public function removePermission(string $permissionName): void;

    public function hasPermissionToSelect(string $permissionName): bool;

    public function hasPermissionSelected(string $permissionName): bool;
}
