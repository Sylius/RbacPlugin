<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

interface AdminPermissionsProviderInterface
{
    /** @return array|string[] */
    public function getPossiblePermissions(): array;

    /** array|string[] */
    public function getPossiblePermissionAccess(): array;
}
