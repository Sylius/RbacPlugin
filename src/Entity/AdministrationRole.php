<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

final class AdministrationRole implements AdministrationRoleInterface
{
    /** @var int */
    private $id;

    /** @var string|null */
    private $name;

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
}
