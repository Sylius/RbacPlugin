<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Factory;

use Sylius\Component\Resource\Factory\TranslatableFactoryInterface;
use Sylius\RbacPlugin\Entity\AdministrationRoleInterface;

interface AdministrationRoleFactoryInterface extends TranslatableFactoryInterface
{
    public function createWithNameAndPermissions(string $name, array $permissions): AdministrationRoleInterface;
}
