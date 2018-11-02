<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Extractor;

interface PermissionDataExtractorInterface
{
    public function extract(array $permissions): array;
}
