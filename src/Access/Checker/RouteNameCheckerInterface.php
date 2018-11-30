<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

interface RouteNameCheckerInterface
{
    public function isAdminRoute(string $routeName): bool;
}
