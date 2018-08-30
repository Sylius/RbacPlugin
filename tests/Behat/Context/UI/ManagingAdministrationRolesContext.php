<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;

final class ManagingAdministrationRolesContext implements Context
{
    /**
     * @When I want to add a new Administration role
     */
    public function wantToAddNewAdministrationRole(): void
    {
        throw new PendingException();
    }

    /**
     * @When I name it :name
     */
    public function nameIt(string $name): void
    {
        throw new PendingException();
    }

    /**
     * @When I add it
     */
    public function addIt(): void
    {
        throw new PendingException();
    }

    /**
     * @Then there should (still) be :count Administration role(s) with name :name within the system
     */
    public function thereShouldBeAdministrationRoleWithNameWithinTheSystem(int $count, string $name): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should be notified that Administration role has been successfully created
     */
    public function shouldBeNotifiedThatAdministrationRoleHasBeenSuccessfullyCreated(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should be notified that this name is already taken
     */
    public function shouldBeNotifiedThatThisNameIsAlreadyTaken(): void
    {
        throw new PendingException();
    }
}
