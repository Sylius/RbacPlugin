<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\IndexPage;

final class AdminUserIndexPage extends IndexPage implements AdminUserIndexPageInterface
{
    public function getAdministrationRoleOfAdminWithEmail(string $email): string
    {
        $table = $this->getElement('table');

        $row = $this->getTableAccessor()->getRowWithFields($table, ['email' => $email]);

        return $this->getTableAccessor()->getFieldFromRow($table, $row, 'administration_role')->getText();
    }
}
