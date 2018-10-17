<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Sylius\RbacPlugin\Entity\AdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;

final class AdministrationRoleCreator implements AdministrationRoleCreatorInterface
{
    public function create(string $administrationRoleName, array $permissions): AdministrationRoleInterface
    {
        $administrationRole = new AdministrationRole();

        $administrationRole->setName($administrationRoleName);

        foreach ($permissions as $permission) {
            $administrationRole->addPermission(new Permission($permission));
        }

        return $administrationRole;
    }
}
