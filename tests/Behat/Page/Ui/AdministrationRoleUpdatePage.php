<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Page\Admin\Crud\UpdatePage;

final class AdministrationRoleUpdatePage extends UpdatePage implements AdministrationRoleUpdatePageInterface
{
    public function addPermission(string $permissionName): void
    {
        $this->getDocument()->selectFieldOption('Permissions', $permissionName, true);
    }

    public function removePermission(string $permissionName): void
    {
        $options = $this->getDocument()->findAll('css', 'select option');

        $values = [];
        /** @var NodeElement $option */
        foreach ($options as $option) {
            if ($option->isSelected() && $option->getText() !== $permissionName) {
                $values[] = $option->getValue();
            }
        }

        $this->getDocument()->find('css', 'select')->setValue($values);
    }

    public function hasPermissionToSelect(string $permissionName): bool
    {
        return
            $this->getDocument()->find('css', sprintf('select option:contains("%s")', $permissionName)) !== null
        ;
    }

    public function hasPermissionSelected(string $permissionName): bool
    {
        $selectedPermissions = [];
        foreach ($this->getDocument()->find('css', 'select')->getValue() as $value) {
            $selectedPermissions[] = $this->getDocument()->find('css', sprintf('option[value="%s"]', $value))->getText();
        }

        return in_array($permissionName, $selectedPermissions);
    }
}
