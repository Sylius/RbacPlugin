<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Model;

use Sylius\RbacPlugin\Access\Model\OperationType;

interface PermissionInterface
{
    public function operationTypes(): ?array;

    public function addOperationType(OperationType $operationType): void;

    public function type(): string;

    public function serialize(): string;
}
