<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;
use Webmozart\Assert\Assert;

final class AdminUserContext implements Context
{
    /** @var ObjectManager */
    private $administratorManager;

    public function __construct(ObjectManager $administratorManager)
    {
        $this->administratorManager = $administratorManager;
    }

    /**
     * @When /^(this administrator) has (administration role "[^"]+")$/
     */
    public function thisAdministratorHasRole(
        AdministrationRoleAwareInterface $administrator,
        AdministrationRoleInterface $administrationRole
    ): void {
        $administrator->setAdministrationRole($administrationRole);

        $this->administratorManager->flush();
    }

    /**
     * @Then /^(this administrator) should have (administration role "([^"]*)")$/
     */
    public function thisAdministratorShouldHaveAdministrationRole(
        AdministrationRoleAwareInterface $administrator,
        AdministrationRoleInterface $administrationRole
    ): void {
        Assert::true($administrator->getAdministrationRole() === $administrationRole);
    }
}
