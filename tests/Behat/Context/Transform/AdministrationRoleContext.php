<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Webmozart\Assert\Assert;

final class AdministrationRoleContext implements Context
{
    /** @var RepositoryInterface */
    private $administrationRoleRepository;

    public function __construct(RepositoryInterface $administrationRoleRepository)
    {
        $this->administrationRoleRepository = $administrationRoleRepository;
    }

    /**
     * @Transform :administrationRole
     * @Transform /^administration role "([^"]+)"$/
     */
    public function getAdministrationRoleByName(string $name): AdministrationRoleInterface
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->administrationRoleRepository->findOneBy(['name' => $name]);
        Assert::notNull($administrationRole, sprintf('There is no administration role with name "%s"', $name));

        return $administrationRole;
    }
}
