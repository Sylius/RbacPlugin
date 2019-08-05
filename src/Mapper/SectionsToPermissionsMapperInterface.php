<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Mapper;

interface SectionsToPermissionsMapperInterface
{
    public function map(string $section): string;
}
