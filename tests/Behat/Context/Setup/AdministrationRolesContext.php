<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class AdministrationRolesContext implements Context
{
    /** @var FactoryInterface */
    private $administrationRoleFactory;

    /** @var RepositoryInterface */
    private $administrationRoleRepository;

    public function __construct(
        FactoryInterface $administrationRoleFactory,
        RepositoryInterface $administrationRoleRepository
    ) {
        $this->administrationRoleFactory = $administrationRoleFactory;
        $this->administrationRoleRepository = $administrationRoleRepository;
    }

    /**
     * @Given there is already an Administration role :name in the system
     */
    public function thereIsAlreadyAdministrationRoleInTheSystem(string $name): void
    {
        $administrationRole = $this->administrationRoleFactory->createNew();
        $administrationRole->setName($name);

        $this->administrationRoleRepository->add($administrationRole);
    }
}
