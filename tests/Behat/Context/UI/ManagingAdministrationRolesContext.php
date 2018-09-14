<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Page\Admin\Crud\IndexPageInterface;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Tests\Sylius\RbacPlugin\Behat\Page\Ui\AdministrationRoleCreatePageInterface;
use Tests\Sylius\RbacPlugin\Behat\Page\Ui\AdministrationRoleUpdatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingAdministrationRolesContext implements Context
{
    /** @var AdministrationRoleCreatePageInterface */
    private $createPage;

    /** @var AdministrationRoleUpdatePageInterface */
    private $updatePage;

    /** @var IndexPageInterface */
    private $indexPage;

    /** @var NotificationCheckerInterface */
    private $notificationChecker;

    public function __construct(
        AdministrationRoleCreatePageInterface $createPage,
        AdministrationRoleUpdatePageInterface $updatePage,
        IndexPageInterface $indexPage,
        NotificationCheckerInterface $notificationChecker
    ) {
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->indexPage = $indexPage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When I want to add a new Administration role
     */
    public function wantToAddNewAdministrationRole(): void
    {
        $this->createPage->open();
    }

    /**
     * @When I want to manage permissions of :administrationRole Administration role
     */
    public function wantToAddSomePermissionsToAdministrationRole(AdministrationRoleInterface $administrationRole): void
    {
        $this->updatePage->open(['id' => $administrationRole->getId()]);
    }

    /**
     * @When I name it :name
     */
    public function nameIt(string $name): void
    {
        $this->createPage->nameIt($name);
    }

    /**
     * @When I add :permissionName permission
     */
    public function addPermission(string $permissionName): void
    {
        $this->updatePage->addPermission($permissionName);
    }

    /**
     * @When I remove :permissionName permission
     */
    public function removePermission(string $permissionName): void
    {
        $this->updatePage->removePermission($permissionName);
    }

    /**
     * @When I add it
     */
    public function addIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @When I save my changes
     */
    public function saveChanges(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then there should (still) be :count Administration role(s) with name :name within the system
     */
    public function thereShouldBeAdministrationRoleWithNameWithinTheSystem(int $count, string $name): void
    {
        $this->indexPage->open();
        Assert::eq($this->indexPage->countItems(), $count);
        Assert::true($this->indexPage->isSingleResourceOnPage(['name' => $name]));
    }

    /**
     * @Then I should be able to select :permissionName permission
     */
    public function shouldBeAbleToSelectPermission(string $permissionName): void
    {
        Assert::true($this->updatePage->hasPermissionToSelect($permissionName));
    }

    /**
     * @Then this Administration role should have :permissionName permission
     */
    public function thisAdministrationRoleShouldHavePermission(string $permissionName): void
    {
        Assert::true($this->updatePage->hasPermissionSelected($permissionName));
    }

    /**
     * @Then this Administration role should not have :permissionName permission
     */
    public function thisAdministrationRoleShouldNotHavePermission(string $permissionName): void
    {
        Assert::false($this->updatePage->hasPermissionSelected($permissionName));
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
     * @Then I should be notified that Administration role has been successfully updated
     */
    public function shouldBeNotifiedThatAdministrationRoleHasBeenSuccessfullyUpdated()
    {
        $this->notificationChecker->checkNotification(
            'Administration role has been successfully updated',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be notified that this name is already taken
     */
    public function shouldBeNotifiedThatThisNameIsAlreadyTaken(): void
    {
        Assert::same(
            $this->createPage->getNameValidationMessage(),
            'This name is already taken'
        );
    }
}
