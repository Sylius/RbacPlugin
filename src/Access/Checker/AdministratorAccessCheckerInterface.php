<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

use Sylius\Component\Core\Model\AdminUserInterface;
use Sylius\RbacPlugin\Access\Model\AccessRequest;

interface AdministratorAccessCheckerInterface
{
    public function canAccessSection(AdminUserInterface $admin, AccessRequest $accessRequest): bool;
}
