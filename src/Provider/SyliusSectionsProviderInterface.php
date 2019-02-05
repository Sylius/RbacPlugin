<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Provider;

interface SyliusSectionsProviderInterface
{
    public function __invoke(): array;
}
