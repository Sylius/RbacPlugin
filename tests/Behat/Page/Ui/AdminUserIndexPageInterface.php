<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\IndexPageInterface;

interface AdminUserIndexPageInterface extends IndexPageInterface
{
    public function getAdministrationRoleOfAdminWithEmail(string $email): string;
}
