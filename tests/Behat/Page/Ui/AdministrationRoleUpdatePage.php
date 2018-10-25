<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\UpdatePage;
use Sylius\RbacPlugin\Model\PermissionAccess;

final class AdministrationRoleUpdatePage extends UpdatePage implements AdministrationRoleUpdatePageInterface
{
    public function addPermission(string $permissionName, array $accesses): void
    {
        foreach ($accesses as $access) {
            /** @var NodeElement $administrationRolePermissionAccess */
            $administrationRolePermissionAccess = $this->findPermissionRoleAccessSwitch($permissionName, $access);

            $administrationRolePermissionAccess->check();
        }
    }

    public function removePermission(string $permissionName): void
    {
        $accesses = [PermissionAccess::READ, PermissionAccess::WRITE];

        foreach ($accesses as $access) {
            /** @var NodeElement $administrationRolePermissionAccess */
            $administrationRolePermissionAccess = $this->findPermissionRoleAccessSwitch($permissionName, $access);

            $administrationRolePermissionAccess->uncheck();
        }
    }

    public function removePermissionAccess($permissionName, $access): void
    {
        $administrationRolePermissionAccess = $this->findPermissionRoleAccessSwitch($permissionName, $access);

        $administrationRolePermissionAccess->uncheck();
    }

    public function isPermissionManageable(string $permissionName): bool
    {
        $isReadAccessGrantable = $this->findPermissionRoleAccessSwitch($permissionName, PermissionAccess::READ) !== null;
        $isWriteAccessGrantable = $this->findPermissionRoleAccessSwitch($permissionName, PermissionAccess::READ) !== null;

        return $isReadAccessGrantable && $isWriteAccessGrantable;
    }

    public function hasActivePermission(string $permissionName, string $access): bool
    {
        $hasReadAccess = $this->findPermissionRoleAccessSwitch($permissionName, PermissionAccess::READ)->isChecked();
        $hasWriteAccess = $this->findPermissionRoleAccessSwitch($permissionName, PermissionAccess::WRITE)->isChecked();

        return $hasReadAccess && $hasWriteAccess;
    }

    public function hasPermissionWithAccessSelected(string $permissionName, string $access): bool
    {
        /** @var NodeElement $administrationRolePermissionAccess */
        $administrationRolePermissionAccess = $this->findPermissionRoleAccessSwitch($permissionName, $access);

        return $administrationRolePermissionAccess->isChecked();
    }

    private function findPermissionRoleAccessSwitch(string $permissionName, string $access): NodeElement
    {
        return $this
            ->getDocument()
            ->findById(strtolower($access) . PermissionAccess::PERMISSION_ACCESS_DELIMITER .
                strtolower(str_replace(' ', '_', $permissionName))
            )
        ;
    }
}
