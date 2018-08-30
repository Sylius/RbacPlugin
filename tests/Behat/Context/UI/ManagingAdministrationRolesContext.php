<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\Admin\Crud\IndexPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\Sylius\RbacPlugin\Behat\Page\Ui\AdministrationRoleCreatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingAdministrationRolesContext implements Context
{
    /** @var AdministrationRoleCreatePageInterface */
    private $administrationRoleCreatePage;

    /** @var IndexPageInterface */
    private $administrationRoleIndexPage;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    public function __construct(
        AdministrationRoleCreatePageInterface $administrationRoleCreatePage,
        IndexPageInterface $administrationRoleIndexPage,
        NotificationCheckerInterface $notificationChecker
    ) {
        $this->administrationRoleCreatePage = $administrationRoleCreatePage;
        $this->administrationRoleIndexPage = $administrationRoleIndexPage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When I want to add a new Administration role
     */
    public function wantToAddNewAdministrationRole(): void
    {
        $this->administrationRoleCreatePage->open();
    }

    /**
     * @When I name it :name
     */
    public function nameIt(string $name): void
    {
        $this->administrationRoleCreatePage->nameIt($name);
    }

    /**
     * @When I add it
     */
    public function addIt(): void
    {
        $this->administrationRoleCreatePage->create();
    }

    /**
     * @Then there should (still) be :count Administration role(s) with name :name within the system
     */
    public function thereShouldBeAdministrationRoleWithNameWithinTheSystem(int $count, string $name): void
    {
        Assert::eq($this->administrationRoleIndexPage->countItems(), $count);
        Assert::true($this->administrationRoleIndexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then I should be notified that Administration role has been successfully created
     */
    public function shouldBeNotifiedThatAdministrationRoleHasBeenSuccessfullyCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Administration role has been successfully created',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that this name is already taken
     */
    public function shouldBeNotifiedThatThisNameIsAlreadyTaken(): void
    {
        Assert::same(
            $this->administrationRoleCreatePage->getNameValidationMessage(),
            'This name is already taken'
        );
    }
}
