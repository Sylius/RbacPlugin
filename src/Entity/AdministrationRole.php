<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Sylius\RbacPlugin\Model\Permission;

/** @final */
class AdministrationRole implements AdministrationRoleInterface
{
    /** @var int */
    private $id;

    /** @var string|null */
    private $name;

    /** @var array|Permission[] */
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

    public function addPermission(Permission $permission): void
    {
        $this->permissions[$permission->type()] = $permission->serialize();
    }

    public function removePermission(Permission $permission): void
    {
        unset($this->permissions[$permission->type()]);
    }

    public function hasPermission(Permission $permission): bool
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
