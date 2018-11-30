<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\UpdatePage;
use Sylius\RbacPlugin\Access\Model\OperationType;

final class AdministrationRoleUpdatePage extends UpdatePage implements AdministrationRoleUpdatePageInterface
{
    public function addPermission(string $permissionName, array $operationTypes): void
    {
        foreach ($operationTypes as $access) {
            /** @var NodeElement $administrationRolePermissionAccess */
            $administrationRolePermissionAccess = $this->findPermissionRoleOperationTypeSwitch($permissionName, $access);

            $administrationRolePermissionAccess->check();
        }
    }

    public function removePermission(string $permissionName): void
    {
        $accesses = [OperationType::READ, OperationType::WRITE];

        foreach ($accesses as $access) {
            /** @var NodeElement $administrationRolePermissionAccess */
            $administrationRolePermissionAccess = $this->findPermissionRoleOperationTypeSwitch($permissionName, $access);

            $administrationRolePermissionAccess->uncheck();
        }
    }

    public function removePermissionAccess(string $permissionName, string $operationType): void
    {
        $administrationRolePermissionAccess =
            $this->findPermissionRoleOperationTypeSwitch($permissionName, $operationType)
        ;

        $administrationRolePermissionAccess->uncheck();
    }

    public function isPermissionManageable(string $permissionName): bool
    {
        $isReadAccessGrantable =
            $this->findPermissionRoleOperationTypeSwitch($permissionName, OperationType::READ) !== null
        ;

        $isWriteAccessGrantable =
            $this->findPermissionRoleOperationTypeSwitch($permissionName, OperationType::READ) !== null
        ;

        return $isReadAccessGrantable && $isWriteAccessGrantable;
    }

    public function hasActiveOperationType(string $permissionName, string $operationType): bool
    {
        $hasReadAccess = $this
            ->findPermissionRoleOperationTypeSwitch($permissionName, OperationType::READ)
            ->isChecked()
        ;

        $hasWriteAccess = $this
            ->findPermissionRoleOperationTypeSwitch($permissionName, OperationType::WRITE)
            ->isChecked()
        ;

        return $hasReadAccess && $hasWriteAccess;
    }

    public function hasPermissionWithAccessSelected(string $permissionName, string $operationType): bool
    {
        /** @var NodeElement $administrationRolePermissionAccess */
        $administrationRolePermissionAccess =
            $this->findPermissionRoleOperationTypeSwitch($permissionName, $operationType)
        ;

        return $administrationRolePermissionAccess->isChecked();
    }

    private function findPermissionRoleOperationTypeSwitch(string $permissionName, string $access): NodeElement
    {
        return $this
            ->getDocument()
            ->find('css', sprintf(
                '#permission_table tr:contains("%s") td[data-label="%s"] input',
                $permissionName, ucfirst($access)
            ))
        ;
    }
}
