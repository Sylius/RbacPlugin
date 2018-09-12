<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui\Administrator;

use Sylius\Behat\Page\Admin\Administrator\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    public function selectAdministrationRole(string $administrationRoleName): void
    {
        $this->getElement('roles')->selectOption($administrationRoleName);
    }

    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'roles' => '#sylius_admin_user_administrationRoles'
        ]);
    }
}
