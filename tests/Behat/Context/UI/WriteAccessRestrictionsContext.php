<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Tests\Sylius\RbacPlugin\Behat\Service\ModifyingAvailabilityChecker;
use Webmozart\Assert\Assert;

final class WriteAccessRestrictionsContext implements Context
{
    /** @var ModifyingAvailabilityChecker */
    private $catalogModifyingAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $configurationModifyingAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $customersModifyingAvailabilityChecker;

    /** @var ModifyingAvailabilityChecker */
    private $marketingModifyingAvailabilityChecker;

    public function __construct(
        ModifyingAvailabilityChecker $catalogModifyingAvailabilityChecker,
        ModifyingAvailabilityChecker $configurationModifyingAvailabilityChecker,
        ModifyingAvailabilityChecker $customersModifyingAvailabilityChecker,
        ModifyingAvailabilityChecker $marketingModifyingAvailabilityChecker
    ) {
        $this->catalogModifyingAvailabilityChecker = $catalogModifyingAvailabilityChecker;
        $this->configurationModifyingAvailabilityChecker = $configurationModifyingAvailabilityChecker;
        $this->customersModifyingAvailabilityChecker = $customersModifyingAvailabilityChecker;
        $this->marketingModifyingAvailabilityChecker = $marketingModifyingAvailabilityChecker;
    }

    /**
     * @Then I should be able to introduce modifications in configuration section
     */
    public function shouldBeAbleToModifySettingsInConfigurationSection(): void
    {
        Assert::true($this->configurationModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should be able to introduce modifications in catalog management section
     */
    public function shouldBeAbleToModifySettingsInCatalogManagementSection(): void
    {
        Assert::true($this->catalogModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should be able to introduce modifications in customers management section
     */
    public function shouldBeAbleToModifySettingsInCustomersManagementSection(): void
    {
        Assert::true($this->customersModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should be able to introduce modifications in marketing management section
     */
    public function shouldBeAbleToModifySettingsInMarketingManagementSection(): void
    {
        Assert::true($this->marketingModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to introduce modifications in configuration section
     */
    public function shouldNotBeAbleToModifySettingsInConfigurationSection(): void
    {
        Assert::false($this->configurationModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to introduce modifications in catalog management section
     */
    public function shouldNotBeAbleToModifySettingsInCatalogManagementSection(): void
    {
        Assert::false($this->catalogModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to introduce modifications in customers management section
     */
    public function shouldNotBeAbleToModifySettingsInCustomersManagementSection(): void
    {
        Assert::false($this->customersModifyingAvailabilityChecker->isModifyingAvailable());
    }

    /**
     * @Then I should not be able to introduce modifications in marketing management section
     */
    public function shouldNotBeAbleToModifySettingsInMarketingManagementSection(): void
    {
        Assert::false($this->marketingModifyingAvailabilityChecker->isModifyingAvailable());
    }
}
