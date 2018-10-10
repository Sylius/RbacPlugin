<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Sylius\Behat\Page\Admin\DashboardPageInterface;

final class AccessRestrictionsContext implements Context
{
    /** @var DashboardPageInterface */
    private $dashboardPage;

    public function __construct(DashboardPageInterface $dashboardPage)
    {
        $this->dashboardPage = $dashboardPage;
    }

    /**
     * @When I view the administrator panel
     */
    public function viewTheAdministratorPanel(): void
    {
        $this->dashboardPage->open();
    }

    /**
     * @Then I should have access to configuration
     */
    public function shouldHaveAccessToConfiguration(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have no access to configuration
     */
    public function shouldHaveNoAccessToConfiguration(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have access to catalog management
     */
    public function shouldHaveAccessToCatalogManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have no access to catalog management
     */
    public function shouldHaveNoAccessToCatalogManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have access to customers management
     */
    public function shouldHaveAccessToCustomerManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have no access to customers management
     */
    public function shouldHaveNoAccessToCustomerManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have access to marketing management
     */
    public function shouldHaveAccessToMarketingManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have no access to marketing management
     */
    public function shouldHaveNoAccessToMarketingManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have access to sales management
     */
    public function shouldHaveAccessToSalesManagement(): void
    {
        throw new PendingException();
    }

    /**
     * @Then I should have no access to sales management
     */
    public function shouldHaveNoAccessToSalesManagement(): void
    {
        throw new PendingException();
    }
}
