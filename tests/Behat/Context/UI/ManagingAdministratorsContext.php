<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Context\UI;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface;
use Tests\Sylius\RbacPlugin\Behat\Page\Ui\Administrator\CreatePageInterface;
use Webmozart\Assert\Assert;

final class ManagingAdministratorsContext
{
    /** @var CreatePageInterface */
    private $createPage;

    /** @var IndexPageInterface */
    private $indexPage;

    public function __construct(CreatePageInterface $createPage, IndexPageInterface $indexPage)
    {
        $this->createPage = $createPage;
        $this->indexPage = $indexPage;
    }

    /**
     * @When I select :administrationRoleName administration role
     */
    public function selectAdministrationRole(string $administrationRoleName): void
    {
        $this->createPage->selectAdministrationRole($administrationRoleName);
    }

    /**
     * @Then there should be administrator :email with role :roleName
     */
    public function itsRoleShouldBe(string $email, string $roleName): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['email' => $email, 'administrationRole' => $roleName]));
    }
}
