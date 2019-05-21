<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;

final class AdminUserContext implements Context
{
    /** @var ObjectManager */
    private $administratorManager;

    public function __construct(ObjectManager $administratorManager)
    {
        $this->administratorManager = $administratorManager;
    }

    /**
     * @Given /^(this administrator) has (administration role "[^"]+")$/
     */
    public function thisAdministratorHasRole(
        AdministrationRoleAwareInterface $administrator,
        AdministrationRoleInterface $administrationRole
    ): void {
        $administrator->setAdministrationRole($administrationRole);

        $this->administratorManager->flush();
    }
}
