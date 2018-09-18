<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Element;

use FriendsOfBehat\PageObjectExtension\Element\Element;

final class AdministrationRolesElement extends Element implements AdministrationRolesElementInterface
{
    public function selectAdministrationRole(string $administrationRoleName): void
    {
        $this->getDocument()->selectFieldOption('sylius_admin_user_administrationRole', $administrationRoleName);
    }

    public function removeAdministrationRole(): void
    {
        $this->getDocument()->selectFieldOption('sylius_admin_user_administrationRole', '');
    }
}
