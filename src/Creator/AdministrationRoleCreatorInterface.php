<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;

interface AdministrationRoleCreatorInterface
{
    public function create(string $administrationRoleName, array $permissions): AdministrationRoleInterface;
}
