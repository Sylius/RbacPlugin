<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Access\Creator;

use Sylius\RbacPlugin\Access\Exception\UnresolvedRouteNameException;
use Sylius\RbacPlugin\Access\Model\AccessRequest;

interface AccessRequestCreatorInterface
{
    /** @throws UnresolvedRouteNameException */
    public function createFromRouteName(string $routeName, string $requestMethod): AccessRequest;
}
