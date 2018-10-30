<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class CreateAdministrationRole extends Command
{
    use PayloadTrait;

    public function __construct(string $administrationRoleName, array $permissions = [])
    {
        $this->init();
        $this->setPayload([
            'administration_role_name' => $administrationRoleName,
            'permissions' => $permissions,
        ]);
    }

    public function administrationRoleName(): string
    {
        return $this->payload()['administration_role_name'];
    }

    public function permissions(): array
    {
        return $this->payload()['permissions'];
    }
}
