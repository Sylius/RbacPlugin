<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Normalizer;

use Sylius\RbacPlugin\Model\PermissionInterface;

interface AdministrationRolePermissionNormalizerInterface
{
    public function normalize(PermissionInterface $permission): PermissionInterface;
}
