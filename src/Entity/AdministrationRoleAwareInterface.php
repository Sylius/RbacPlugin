<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Entity;

interface AdministrationRoleAwareInterface
{
    public function setAdministrationRole(AdministrationRoleInterface $administrationRole): void;

    public function getAdministrationRole(): ?AdministrationRoleInterface;
}
