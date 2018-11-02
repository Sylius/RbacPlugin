<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

final class UpdateAdministrationRole extends Command
{
    use PayloadTrait;

    public function __construct(int $id, string $administrationRoleName, array $permissions = [])
    {
        $this->init();
        $this->setPayload([
            'administration_role_id' => $id,
            'administration_role_name' => $administrationRoleName,
            'permissions' => $permissions,
        ]);
    }

    public function administrationRoleId(): int
    {
        return $this->payload()['administration_role_id'];
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
