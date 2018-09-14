<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui\Administrator;

use Sylius\Behat\Page\Admin\Administrator\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function selectAdministrationRole(string $administrationRoleName): void;
}
