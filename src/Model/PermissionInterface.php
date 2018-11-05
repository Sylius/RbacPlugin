<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Model;

interface PermissionInterface
{
    public function operationTypes(): ?array;

    public function addOperationType(string $operationType): void;

    public function type(): string;

    public function serialize(): string;
}
