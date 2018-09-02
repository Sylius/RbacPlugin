<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;

interface AdministrationRoleInterface extends ResourceInterface
{
    public function getName(): ?string;

    public function setName(?string $name): void;
}
