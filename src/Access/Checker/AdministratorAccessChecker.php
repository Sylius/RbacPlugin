<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Access\Model\Section;
use Sylius\RbacPlugin\Entity\AdminUserInterface;
use Sylius\RbacPlugin\Model\Permission;
use Webmozart\Assert\Assert;

final class AdministratorAccessChecker implements AdministratorAccessCheckerInterface
{
    public function canAccessSection(AdminUserInterface $admin, AccessRequest $accessRequest): bool
    {
        $administrationRole = $admin->getAdministrationRole();
        Assert::notNull($administrationRole);

        foreach ($administrationRole->getPermissions() as $permission) {
            if ($this->getSectionForPermission($permission)->equals($accessRequest->section())) {
                return true;
            }
        }

        return false;
    }

    private function getSectionForPermission(Permission $permission): Section
    {
        switch (true) {
            case $permission->equals(Permission::configuration()):
                return Section::configuration();
            case $permission->equals(Permission::catalogManagement()):
                return Section::catalog();
            case $permission->equals(Permission::marketingManagement()):
                return Section::marketing();
            case $permission->equals(Permission::customerManagement()):
                return Section::customers();
            case $permission->equals(Permission::salesManagement()):
                return Section::sales();
        }

        return Section::ofType($permission->type());
    }
}
