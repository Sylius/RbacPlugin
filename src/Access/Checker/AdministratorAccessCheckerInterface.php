<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

use Sylius\RbacPlugin\Access\Model\AccessRequest;
use Sylius\RbacPlugin\Entity\AdminUserInterface;

interface AdministratorAccessCheckerInterface
{
    public function canAccessSection(AdminUserInterface $admin, AccessRequest $accessRequest): bool;
}
