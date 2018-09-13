<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\RbacPlugin\Model\Permission;

interface AdministrationRoleInterface extends ResourceInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;

    public function addPermission(Permission $permission): void;

    public function removePermission(Permission $permission): void;

    public function hasPermission(Permission $permission): bool;

    public function getPermissions(): array;
}
