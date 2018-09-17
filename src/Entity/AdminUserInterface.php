<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Sylius\Component\Core\Model\AdminUserInterface as BaseAdminUserInterface;

interface AdminUserInterface extends BaseAdminUserInterface
{
    public function setAdministrationRole(AdministrationRole $administrationRole): void;

    public function getAdministrationRole(): ?AdministrationRoleInterface;
}
