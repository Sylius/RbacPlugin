<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Sylius\Behat\Page\Admin\DashboardPageInterface;
use Tests\Sylius\RbacPlugin\Behat\Service\ModifyingAvailabilityChecker;
use Tests\Sylius\RbacPlugin\Behat\Service\PagesAvailabilityChecker;
use Webmozart\Assert\Assert;

final class AccessRestrictionsContext implements Context
{
    /** @var DashboardPageInterface */
    private $dashboardPage;

    /** @var PagesAvailabilityChecker */
    private $catalogPagesAvailabilityChecker;

    /** @var PagesAvailabilityChecker */
    private $configurationPagesAvailabilityChecker;

    /** @var PagesAvailabilityChecker */
    private $customersPagesAvailabilityChecker;

    /** @var PagesAvailabilityChecker */
    private $marketingPagesAvailabilityChecker;

    /** @var PagesAvailabilityChecker */
    private $salesPagesAvailabilityChecker;

    /** @var PagesAvailabilityChecker */
    private $rbacPagesAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $catalogModifyingAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $configurationModifyingAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $customersModifyingAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $marketingModifyingAvailabilityChecker;

    public function __construct(
        DashboardPageInterface $dashboardPage,
        PagesAvailabilityChecker $catalogPagesAvailabilityChecker,
        PagesAvailabilityChecker $configurationPagesAvailabilityChecker,
        PagesAvailabilityChecker $customersPagesAvailabilityChecker,
        PagesAvailabilityChecker $marketingPagesAvailabilityChecker,
        PagesAvailabilityChecker $salesPagesAvailabilityChecker,
        PagesAvailabilityChecker $rbacPagesAvailabilityChecker,
        ModifyingAvailabilityChecker $catalogModifyingAvailabilityChecker,
        ModifyingAvailabilityChecker $configurationModifyingAvailabilityChecker,
        ModifyingAvailabilityChecker $customersModifyingAvailabilityChecker,
        ModifyingAvailabilityChecker $marketingModifyingAvailabilityChecker
    ) {
        $this->dashboardPage = $dashboardPage;
        $this->catalogPagesAvailabilityChecker = $catalogPagesAvailabilityChecker;
        $this->configurationPagesAvailabilityChecker = $configurationPagesAvailabilityChecker;
        $this->customersPagesAvailabilityChecker = $customersPagesAvailabilityChecker;
        $this->marketingPagesAvailabilityChecker = $marketingPagesAvailabilityChecker;
        $this->salesPagesAvailabilityChecker = $salesPagesAvailabilityChecker;
        $this->rbacPagesAvailabilityChecker = $rbacPagesAvailabilityChecker;
        $this->catalogModifyingAvailabilityChecker = $catalogModifyingAvailabilityChecker;
        $this->configurationModifyingAvailabilityChecker = $configurationModifyingAvailabilityChecker;
        $this->customersModifyingAvailabilityChecker = $customersModifyingAvailabilityChecker;
        $this->marketingModifyingAvailabilityChecker = $marketingModifyingAvailabilityChecker;
    }

    /**
     * @When I view the administrator panel
     */
    public function viewTheAdministratorPanel(): void
    {
        $this->dashboardPage->tryToOpen();
    }

    /**
     * @Then I should have access to configuration
     */
    public function shouldHaveAccessToConfiguration(): void
    {
        Assert::true($this->configurationPagesAvailabilityChecker->areAllPagesAvailable());
    }

    /**
     * @Then I should have no access to configuration
     */
    public function shouldHaveNoAccessToConfiguration(): void
    {
        Assert::true($this->configurationPagesAvailabilityChecker->areAllPagesUnavailable());
    }

    /**
     * @Then I should have access to catalog management
     */
    public function shouldHaveAccessToCatalogManagement(): void
    {
        Assert::true($this->catalogPagesAvailabilityChecker->areAllPagesAvailable());
    }

    /**
     * @Then I should have no access to catalog management
     */
    public function shouldHaveNoAccessToCatalogManagement(): void
    {
        Assert::true($this->catalogPagesAvailabilityChecker->areAllPagesUnavailable());
    }

    /**
     * @Then I should have access to customers management
     */
    public function shouldHaveAccessToCustomerManagement(): void
    {
        Assert::true($this->customersPagesAvailabilityChecker->areAllPagesAvailable());
    }

    /**
     * @Then I should have no access to customers management
     */
    public function shouldHaveNoAccessToCustomerManagement(): void
    {
        Assert::true($this->customersPagesAvailabilityChecker->areAllPagesUnavailable());
    }

    /**
     * @Then I should have access to marketing management
     */
    public function shouldHaveAccessToMarketingManagement(): void
    {
        Assert::true($this->marketingPagesAvailabilityChecker->areAllPagesAvailable());
    }

    /**
     * @Then I should have no access to marketing management
     */
    public function shouldHaveNoAccessToMarketingManagement(): void
    {
        Assert::true($this->marketingPagesAvailabilityChecker->areAllPagesUnavailable());
    }

    /**
     * @Then I should have access to sales management
     */
    public function shouldHaveAccessToSalesManagement(): void
    {
        Assert::true($this->salesPagesAvailabilityChecker->areAllPagesAvailable());
    }

    /**
     * @Then I should have no access to sales management
     */
    public function shouldHaveNoAccessToSalesManagement(): void
    {
        Assert::true($this->salesPagesAvailabilityChecker->areAllPagesUnavailable());
    }

    /**
     * @Then I should have access to RBAC
     */
    public function shouldHaveAccessToRbac(): void
    {
        Assert::true($this->rbacPagesAvailabilityChecker->areAllPagesAvailable());
    }

    /**
     * @Then I should have no access to RBAC
     */
    public function shouldHaveNoAccessToRbac(): void
    {
        Assert::true($this->rbacPagesAvailabilityChecker->areAllPagesUnavailable());
    }

    /**
     * @Then I should be able to modify settings in configuration section
     */
    public function shouldBeAbleToModifySettingsInConfigurationSection(): void
    {
        Assert::true($this->configurationModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should be able to modify settings in catalog management section
     */
    public function shouldBeAbleToModifySettingsInCatalogManagementSection(): void
    {
        Assert::true($this->catalogModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should be able to modify settings in customers management section
     */
    public function shouldBeAbleToModifySettingsInCustomersManagementSection(): void
    {
        Assert::true($this->customersModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should be able to modify settings in marketing management section
     */
    public function shouldBeAbleToModifySettingsInMarketingManagementSection(): void
    {
        Assert::true($this->marketingModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to modify settings in configuration section
     */
    public function shouldNotBeAbleToModifySettingsInConfigurationSection(): void
    {
        Assert::false($this->configurationModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to modify settings in catalog management section
     */
    public function shouldNotBeAbleToModifySettingsInCatalogManagementSection(): void
    {
        Assert::false($this->catalogModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to modify settings in customers management section
     */
    public function shouldNotBeAbleToModifySettingsInCustomersManagementSection(): void
    {
        Assert::false($this->customersModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to modify settings in marketing management section
     */
    public function shouldNotBeAbleToModifySettingsInMarketingManagementSection(): void
    {
        Assert::false($this->marketingModifyingAvailabilityChecker->isModifyingAvailable());
    }
}
