<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Model;

final class PermissionAccess
{
    public const READ = "read";
    public const WRITE = "write";
    public const PERMISSION_ACCESS_DELIMITER = '~';

    private function __construct() {}
}
