<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Behat\Behat\Context\Context;
use Sylius\Behat\Page\Admin\Administrator\UpdatePageInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
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

    public function __construct(
        AdministrationRolesElementInterface $administrationRolesElement,
        AdminUserIndexPageInterface $indexPage,
        UpdatePageInterface $updatePage,
        UserRepositoryInterface $adminUserRepository
    ) {
        $this->administrationRolesElement = $administrationRolesElement;
        $this->indexPage = $indexPage;
        $this->updatePage = $updatePage;
        $this->adminUserRepository = $adminUserRepository;
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
}
