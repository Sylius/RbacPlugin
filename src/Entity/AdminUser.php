<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Sylius\Component\Core\Model\AdminUser as BaseAdminUser;

/** @final */
class AdminUser extends BaseAdminUser implements AdminUserInterface
{
    /** @var AdministrationRoleInterface|null */
    private $administrationRole;

    public function setAdministrationRole(AdministrationRole $administrationRole): void
    {
        $this->administrationRole = $administrationRole;
    }

    public function getAdministrationRole(): ?AdministrationRoleInterface
    {
        return $this->administrationRole;
    }
}
