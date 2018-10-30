<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Tests\Sylius\RbacPlugin\Behat\Element\AdminMainMenuElementInterface;

final class AdminMainMenuContext implements Context
{
    /** @var AdminMainMenuElementInterface */
    private $adminMainMenuElement;

    public function __construct(AdminMainMenuElementInterface $adminMainMenuElement)
    {
        $this->adminMainMenuElement = $adminMainMenuElement;
    }

    /**
     * @Then only :sectionName section should be available in the main menu
     */
    public function shouldSeeOnlySpecificSectionInTheMainMenu(string $sectionName): void
    {
        $availableSections = $this->adminMainMenuElement->getAvailableSections();

        if (count($availableSections) !== 1 || $availableSections[0] !== $sectionName) {
            throw new \Exception(sprintf('There should be only one section available in main menu, named "%s"', $sectionName));
        }
    }
}