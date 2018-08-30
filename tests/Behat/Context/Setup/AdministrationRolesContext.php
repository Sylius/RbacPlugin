<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;

final class AdministrationRolesContext implements Context
{
    /**
     * @Given there is already an Administration role :name in the system
     */
    public function thereIsAlreadyAdministrationRoleInTheSystem(string $name): void
    {
        throw new PendingException();
    }
}
