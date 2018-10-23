<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Model;

interface PermissionInterface
{
    public function accesses(): array;

    public function addAccess(string $access): void;

    public function type(): string;

    public function serialize(): string;
}
