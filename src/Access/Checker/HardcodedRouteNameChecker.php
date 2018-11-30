<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

final class HardcodedRouteNameChecker implements RouteNameCheckerInterface
{
    public function isAdminRoute(string $routeName): bool
    {
        return
            strpos($routeName, 'sylius_admin') !== false ||
            strpos($routeName, 'sylius_rbac_admin') !== false
        ;
    }
}
