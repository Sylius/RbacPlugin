<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;
use Webmozart\Assert\Assert;

final class AdminUserContext implements Context
{
    /** @var ObjectManager */
    private $administratorManager;

    /** @var ExampleFactoryInterface */
    private $adminUserExampleFactory;

    /** @var UserRepositoryInterface */
    private $adminUserRepository;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(ObjectManager $administratorManager, ExampleFactoryInterface $adminUserExampleFactory, UserRepositoryInterface $adminUserRepository, SharedStorageInterface $sharedStorage)
    {
        $this->administratorManager = $administratorManager;
        $this->adminUserExampleFactory = $adminUserExampleFactory;
        $this->adminUserRepository = $adminUserRepository;
        $this->sharedStorage = $sharedStorage;
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

    /**
     * @When I want to add a new administrator :email named :firstName last name :lastname and locale :locale
     */
    public function iWantToAddAnNewAdministratorNamedLastName(string $email, string $firstName, string $lastname, string $locale): void
    {
        $adminUser = $this->adminUserExampleFactory->create([
            'email' => $email,
            'username' => $email,
            'password' => $email,
            'enabled' => true,
            'locale_code' => $locale,
            'first_name' => $firstName,
            'last_name' => $lastname,
        ]);

        $this->adminUserRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }

    /**
     * @Then I should seeing administrator account :email named :firstName last name :lastname and locale :locale
     */
    public function iShouldSeeAdministratorAccountNamedLastNameAndLocale(string $email, string $firstName, string $lastname, string $locale): void
    {
        /** @var AdminUserInterface $user */
        $user = $this->adminUserRepository->findOneBy(['email' => $email]);
        Assert::true(
            $user->getEmail() === $email &&
            $user->getFirstName() === $firstName &&
            $user->getLastName() === $lastname &&
            $user->getUsername() === $email &&
            $user->getLocaleCode() === $locale &&
            $user->isEnabled() === true
        );
    }

    /**
     * @Given /^I should seeing that (this administrator) has (administration role "[^"]+")$/
     */
    public function iShouldSeeThatThisAdministratorHasAdministrationRole(
        AdministrationRoleAwareInterface $administrator,
        AdministrationRoleInterface $administrationRole
    ): void {
        Assert::true($administrator->getAdministrationRole() === $administrationRole);
    }
}
