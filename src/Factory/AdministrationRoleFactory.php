<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Factory;

use Sylius\RbacPlugin\Entity\AdministrationRole;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;
use Sylius\RbacPlugin\Model\Permission;

final class AdministrationRoleFactory implements AdministrationRoleFactoryInterface
{
    public function createWithNameAndPermissions(string $name, array $permissions): AdministrationRoleInterface
    {
        $administrationRole = new AdministrationRole();

        $administrationRole->setName($name);

        /** @var string $permission */
        foreach ($permissions as $permission) {
            $administrationRole->addPermission(new Permission($permission));
        }

        return $administrationRole;
    }

    public function createNew(): AdministrationRoleInterface
    {
        return new AdministrationRole();
    }
}
