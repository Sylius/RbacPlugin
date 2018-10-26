<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Sylius\RbacPlugin\Model\Permission;
use Sylius\RbacPlugin\Model\PermissionInterface;

/** @final */
class AdministrationRole implements AdministrationRoleInterface
{
    /** @var int */
    private $id;

    /** @var string|null */
    private $name;

    /** @var array|string[] */
    private $permissions = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function addPermission(PermissionInterface $permission): void
    {
        $this->permissions[$permission->type()] = $permission->serialize();
    }

    public function removePermission(PermissionInterface $permission): void
    {
        unset($this->permissions[$permission->type()]);
    }

    public function clearPermissions(): void
    {
        $this->permissions = [];
    }

    public function hasPermission(PermissionInterface $permission): bool
    {
        return
            isset($this->permissions[$permission->type()]) &&
            $this->permissions[$permission->type()] === $permission->serialize()
        ;
    }

    public function getPermissions(): array
    {
        $permissions = [];
        /** @var string $permission */
        foreach ($this->permissions as $permission) {
            $permissions[] = Permission::unserialize($permission);
        }

        return $permissions;
    }
}
