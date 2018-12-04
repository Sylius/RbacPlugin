<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Element;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Element\Element;

final class AdministrationRolesElement extends Element implements AdministrationRolesElementInterface
{
    public function selectAdministrationRole(string $administrationRoleName): void
    {
        $this->getDocument()->selectFieldOption('sylius_admin_user_administrationRole', $administrationRoleName);
    }

    public function canRemoveAdministrationRole(): bool
    {
        /** @var NodeElement $administrationRole */
        $administrationRole = $this
            ->getDocument()
            ->findById('sylius_admin_user_administrationRole')
            ->find('named', ['option', ''])
        ;

        if ('' === $administrationRole->getText()) {
            return true;
        }

        return false;
    }
}
