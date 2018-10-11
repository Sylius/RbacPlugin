<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Sylius\RbacPlugin\Model\Permission;

final class AdministratorAccessChecker implements AdministratorAccessCheckerInterface
{
    public function hasAccessToSection(AdminUserInterface $admin, AccessRequest $accessRequest): bool
    {
        $administrationRole = $admin->getAdministrationRole();

        foreach ($administrationRole->getPermissions() as $permission) {
            if ($this->getSectionForPermission($permission)->equals($accessRequest->section())) {
                return true;
            }
        }

        return false;
    }

    private function getSectionForPermission(Permission $permission): Section
    {
        if ($permission->equals(Permission::configuration())) {
            return Section::configuration();
        }

        if ($permission->equals(Permission::catalogManagement())) {
            return Section::catalog();
        }

        if ($permission->equals(Permission::marketingManagement())) {
            return Section::marketing();
        }

        if ($permission->equals(Permission::customerManagement())) {
            return Section::customers();
        }

        if ($permission->equals(Permission::salesManagement())) {
            return Section::sales();
        }

        throw new \Exception('Unrecognized permission');
    }
}
