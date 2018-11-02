<?php

declare(strict_types=1);

namespace Sylius\RbacPlugin\Creator;

use Prooph\Common\Messaging\Command;
use Sylius\RbacPlugin\Command\UpdateAdministrationRole;
use Symfony\Component\HttpFoundation\Request;

final class UpdateAdministrationRoleCommandCreator implements CommandCreatorInterface
{
    public function fromRequest(Request $request): Command
    {
        $command = new UpdateAdministrationRole(
            $request->attributes->getInt('id'),
            $request->request->get('administration_role_name'),
            $request->request->get('permissions', [])
        );

        return $command;
    }
}
