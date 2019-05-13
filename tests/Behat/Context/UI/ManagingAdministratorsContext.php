<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Behat\Page\Admin\Administrator\UpdatePageInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleAwareInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Tests\Sylius\RbacPlugin\Behat\Element\AdministrationRolesElementInterface;
use Tests\Sylius\RbacPlugin\Behat\Page\Ui\AdminUserIndexPageInterface;
use Webmozart\Assert\Assert;

final class ManagingAdministratorsContext implements Context
{
    /** @var AdministrationRolesElementInterface */
    private $administrationRolesElement;

    /** @var AdminUserIndexPageInterface */
    private $indexPage;

    /** @var UpdatePageInterface */
    private $updatePage;

    /** @var UserRepositoryInterface */
    private $adminUserRepository;

    /** @var ObjectManager */
    private $administratorManager;

    /** @var ExampleFactoryInterface */
    private $adminUserExampleFactory;

    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(
        AdministrationRolesElementInterface $administrationRolesElement,
        AdminUserIndexPageInterface $indexPage,
        UpdatePageInterface $updatePage,
        UserRepositoryInterface $adminUserRepository,
        ObjectManager $administratorManager,
        ExampleFactoryInterface $adminUserExampleFactory,
        SharedStorageInterface $sharedStorage
    ) {
        $this->administrationRolesElement = $administrationRolesElement;
        $this->indexPage = $indexPage;
        $this->updatePage = $updatePage;
        $this->adminUserRepository = $adminUserRepository;
        $this->administratorManager = $administratorManager;
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
     * @When I want to edit administrator :email
     */
    public function wantToEditAdministrator(string $email): void
    {
        $administrator = $this->adminUserRepository->findOneByEmail($email);
        Assert::notNull($administrator);

        $this->updatePage->open(['id' => $administrator->getId()]);
    }

    /**
     * @When I select :administrationRoleName administration role
     */
    public function selectAdministrationRole(string $administrationRoleName): void
    {
        $this->administrationRolesElement->selectAdministrationRole($administrationRoleName);
    }

    /**
     * @Then I should not be able to remove their role
     */
    public function shouldNotBeAbleToRemoveTheirRole(): void
    {
        Assert::false($this->administrationRolesElement->canRemoveAdministrationRole());
    }

    /**
     * @Then administrator :email should have role :roleName
     */
    public function administratorShouldHaveRoleAssigned(string $email, string $roleName): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['email' => $email, 'administration_role' => $roleName]));
    }

    /**
     * @Then administrator :email should have no role assigned
     */
    public function administratorShouldHaveNoRoleAssigned(string $email): void
    {
        Assert::same('', $this->indexPage->getAdministrationRoleOfAdminWithEmail($email));
    }

    /**
     * @Then administrator account :email should have first name :firstName and last name :lastname
     */
    public function administratorAccountShouldHaveFirstNameAndLastName(string $email, string $firstName, string $lastname): void
    {
        /** @var AdminUserInterface $user */
        $user = $this->adminUserRepository->findOneBy(['email' => $email]);
        Assert::true(
            $user->getEmail() === $email &&
            $user->getFirstName() === $firstName &&
            $user->getLastName() === $lastname &&
            $user->getUsername() === $email &&
            $user->isEnabled() === true
        );
    }
}
