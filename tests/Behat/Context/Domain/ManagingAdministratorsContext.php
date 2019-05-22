<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Domain;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Webmozart\Assert\Assert;

final class ManagingAdministratorsContext implements Context
{
    /** @var UserRepositoryInterface */
    private $adminUserRepository;

    /** @var ExampleFactoryInterface */
    private $adminUserExampleFactory;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(
        UserRepositoryInterface $adminUserRepository,
        ExampleFactoryInterface $adminUserExampleFactory,
        SharedStorageInterface $sharedStorage
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->adminUserExampleFactory = $adminUserExampleFactory;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @When I add a new administrator :email named :firstName with :lastname last name and :administrationRole administration role
     */
    public function iAddANewAdministratorNamedWithLastNameAndAdministrationRole(
        string $email,
        string $firstName,
        string $lastname,
        AdministrationRoleInterface $administrationRole
    ): void {
        $adminUser = $this->adminUserExampleFactory->create([
            'email' => $email,
            'username' => $email,
            'password' => $email,
            'enabled' => true,
            'first_name' => $firstName,
            'last_name' => $lastname,
            'administration_role' => $administrationRole
        ]);

        $this->adminUserRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }

    /**
     * @Then the administrator account :email should have :firstName first name and :lastName last name
     */
    public function theAdministratorAccountShouldHaveFirstNameAndLastName(string $email, string $firstName, string $lastName): void
    {
        /** @var AdminUserInterface $user */
        $user = $this->adminUserRepository->findOneBy(['email' => $email]);
        Assert::true(
            $user->getEmail() === $email &&
            $user->getFirstName() === $firstName &&
            $user->getLastName() === $lastName &&
            $user->getUsername() === $email &&
            $user->isEnabled() === true
        );
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
