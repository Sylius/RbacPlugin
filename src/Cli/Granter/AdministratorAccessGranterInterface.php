<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Cli\Granter;

interface AdministratorAccessGranterInterface
{
    public function __invoke(string $email, string $roleName, array $sections): void;
}
