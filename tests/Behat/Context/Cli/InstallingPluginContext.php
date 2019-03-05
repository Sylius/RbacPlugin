<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Cli;

use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\RbacPlugin\Cli\InstallPluginCommand;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\PermissionInterface;
use Sylius\RbacPlugin\Provider\SyliusSectionsProviderInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Tests\Application\RbacPlugin\Entity\AdminUser;
use Webmozart\Assert\Assert;

final class InstallingPluginContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Application */
    private $application;

    /** @var CommandTester */
    private $tester;

    /** @var InstallPluginCommand */
    private $command;

    /** @var RepositoryInterface */
    private $administratorRepository;

    /** @var RepositoryInterface */
    private $administrationRoleRepository;

    /** @var SyliusSectionsProviderInterface */
    private $syliusSectionsProvider;

    public function __construct(
        KernelInterface $kernel,
        InstallPluginCommand $command,
        RepositoryInterface $administratorRepository,
        RepositoryInterface $administrationRoleRepository,
        SyliusSectionsProviderInterface $syliusSectionsProvider
    ) {
        $this->kernel = $kernel;
        $this->command = $command;
        $this->administratorRepository = $administratorRepository;
        $this->administrationRoleRepository = $administrationRoleRepository;
        $this->syliusSectionsProvider = $syliusSectionsProvider;
    }

    /**
     * @When I install RBAC plugin
     */
    public function installRbacPlugin(): void
    {
        $this->application = new Application($this->kernel);
        $this->application->add($this->command);

        $command = $this->application->find('sylius-rbac:install-plugin');
        $this->tester = new CommandTester($command);

        $this->tester->execute(['command' => 'sylius-rbac:install-plugin']);
    }

    public function specifyRootAdministratorsEmailAs(string $email): void
    {
        $this->tester->getInput()->setArgument('administratorEmail', $email);
    }

    /**
     * @Then there should be :roleName administration role
     */
    public function thereShouldBeRole(string $roleName): void
    {
        $administrationRole = $this->getAdministrationRole($roleName);

        Assert::notNull($administrationRole);
    }

    /**
     * @Then the :roleName role shouldn't have access to any section
     */
    public function roleShouldNotHaveAccessToAnySection(string $roleName): void
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->getAdministrationRole($roleName);

        Assert::true(empty($administrationRole->getPermissions()));
    }

    /**
     * @Then the :roleName role should have access to every section
     */
    public function roleShouldHaveAccessToEverySection(string $roleName): void
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->getAdministrationRole($roleName);

        $permissionTypes = array_map(function(PermissionInterface $permission): string {
            return $permission->type();
        }, $administrationRole->getPermissions());

        $availableSyliusSections = $this->syliusSectionsProvider->__invoke();

        foreach ($permissionTypes as $permission) {
            if (!in_array($permission, $availableSyliusSections)) {
                throw new \Exception(sprintf(
                    'Administration role does not have a permission for %s section', $permission
                ));
            }
        }
    }

    /**
     * @Then the administrator :email should have :roleName role
     */
    public function administratorShouldHaveRole(string $email, string $roleName): void
    {
        /** @var AdminUser $administrator */
        $administrator = $this->administratorRepository->findOneBy(['email' => $email]);

        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $administrator->getAdministrationRole();

        Assert::eq($administrationRole->getName(), $roleName);
    }

    private function getAdministrationRole(string $roleName): AdministrationRoleInterface
    {
        /** @var AdministrationRoleInterface $administrationRole */
        $administrationRole = $this->administrationRoleRepository->findOneBy(['name' => $roleName]);

        return $administrationRole;
    }
}
