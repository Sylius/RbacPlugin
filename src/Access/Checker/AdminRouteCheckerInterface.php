<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Checker;

interface AdminRouteCheckerInterface
{
    public function __invoke(string $routeName): bool;
}
