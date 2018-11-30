<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Sylius\Behat\Page\Admin\DashboardPageInterface;
use Tests\Sylius\RbacPlugin\Behat\Service\PagesAvailabilityChecker;
use Webmozart\Assert\Assert;

final class ReadAccessRestrictionsContext implements Context
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

    public function __construct(
        DashboardPageInterface $dashboardPage,
        PagesAvailabilityChecker $catalogPagesAvailabilityChecker,
        PagesAvailabilityChecker $configurationPagesAvailabilityChecker,
        PagesAvailabilityChecker $customersPagesAvailabilityChecker,
        PagesAvailabilityChecker $marketingPagesAvailabilityChecker,
        PagesAvailabilityChecker $salesPagesAvailabilityChecker,
        PagesAvailabilityChecker $rbacPagesAvailabilityChecker
    ) {
        $this->dashboardPage = $dashboardPage;
        $this->catalogPagesAvailabilityChecker = $catalogPagesAvailabilityChecker;
        $this->configurationPagesAvailabilityChecker = $configurationPagesAvailabilityChecker;
        $this->customersPagesAvailabilityChecker = $customersPagesAvailabilityChecker;
        $this->marketingPagesAvailabilityChecker = $marketingPagesAvailabilityChecker;
        $this->salesPagesAvailabilityChecker = $salesPagesAvailabilityChecker;
        $this->rbacPagesAvailabilityChecker = $rbacPagesAvailabilityChecker;
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
}
