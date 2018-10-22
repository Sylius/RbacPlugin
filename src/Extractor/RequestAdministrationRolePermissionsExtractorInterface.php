<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Extractor;

interface RequestAdministrationRolePermissionsExtractorInterface
{
    public function extract(array $requestParameters): array;
}
