<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui\Administrator;

use Sylius\Behat\Page\Admin\Administrator\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    public function selectAdministrationRole(string $administrationRoleName): void
    {
        $this->getDocument()->selectFieldOption('sylius_admin_user_administrationRole', $administrationRoleName);
    }
}
