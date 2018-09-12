<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\UpdatePage;

final class AdministrationRoleUpdatePage extends UpdatePage implements AdministrationRoleUpdatePageInterface
{
    public function addPermission(string $permissionName): void
    {
        $this->getDocument()->selectFieldOption('Permissions', $permissionName, true);
    }

    public function removePermission(string $permissionName): void
    {
        $this->getDocument()->selectFieldOption('Permissions', null, true);
    }

    public function hasPermissionToSelect(string $permissionName): bool
    {
        return
            $this->getDocument()->find('css', sprintf('select option:contains("%s")', $permissionName)) !== null
        ;
    }

    public function hasPermissionSelected(string $permissionName): bool
    {
        return
            $this->getDocument()->find('css', 'select')->getValue() === $permissionName
        ;
    }
}
