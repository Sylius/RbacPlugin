<?php

declare(strict_types=1);

namespace Tests\Sylius\RbacPlugin\Behat\Page\Ui;

use Sylius\Behat\Page\Admin\Crud\CreatePage;

final class AdministrationRoleCreatePage extends CreatePage implements AdministrationRoleCreatePageInterface
{
    public function nameIt(string $name): void
    {
        $this->getDocument()->fillField('Name', $name);
    }

    public function getNameValidationMessage(): ?string
    {
        $validationMessage = $this
            ->getDocument()
            ->find('css', '[name="sylius_rbac_administration_role_name"] ~ .sylius-validation-message')
        ;

        return $validationMessage ? null : $validationMessage->getText();
    }
}
