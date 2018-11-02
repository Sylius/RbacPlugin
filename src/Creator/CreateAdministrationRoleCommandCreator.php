<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\CreateAdministrationRole;
use Symfony\Component\HttpFoundation\Request;

final class CreateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    public function fromRequest(Request $request): Command
    {
        $command = new CreateAdministrationRole(
            $request->request->get('administration_role_name'),
            $request->request->get('permissions', [])
        );

        return $command;
    }
}
